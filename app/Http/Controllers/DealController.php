<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\DealTag;
use App\Models\DealUser;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request = null)
    {
        $deals = [];
        if (isset(auth()->user()->id)) {
            $dealUser = DealUser::where([
                ['user_id', auth()->user()->id],
                ['permission_id', '>', 0],
            ])->select('deal_id')->get();

            $dealUsers = [];
            if (count($dealUser) > 0) {
                foreach ($dealUser as $item) {
                    $dealUsers[] = $item->deal_id;
                }
            }

            $deals = Deal::orderBy('id', 'asc')->where('user_id', auth()->user()->id)->orWhereIn('id', $dealUsers);
            if (isset($_GET['filter'])) {
                foreach ($_GET['filter'] as $k => $value) {
                    if ($k == 0) {
                        $dealTag = DealTag::select('deal_id')->where('tag_id', htmlspecialchars($value));
                    } else {
                        $dealTag = $dealTag->orWhere('tag_id', htmlspecialchars($value));
                    }
                }
                $dealTag = $dealTag->get();

                $dealIds = [];
                if (count($dealTag) > 0) {
                    foreach ($dealTag as $item) {
                        $dealIds[] = $item->deal_id;
                    }
                    foreach ($dealIds as $dealId){
                        $deals = $deals->orHaving('id', $dealId);
                    }
                }else{
                    $deals = [];
                    return view('deals.index', compact('deals'));
                }
            }
            $deals = $deals->paginate(5);
        }
        return view('deals.index', compact('deals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $tags = Tag::pluck('title', 'id')->all();
        return view('deals.create', compact('tags'));
    }

    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $deal = [];
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'thumbnail' => 'nullable|image',
            ]);
        } catch (\Exception $e) {
            $deal['error'] = $e->getMessage();
            return $deal;
        }

        $data = $request->all();
        $res = Deal::uploadImage($request);
        $data['thumbnail'] = isset($res['thumbnail']) ? $res['thumbnail'] : '';
        $data['preview_img'] = isset($res['preview_img']) ? $res['preview_img'] : '';
        $data['user_id'] = isset(auth()->user()->id) ? auth()->user()->id : 0;
        $deal = Deal::create($data);

        $tags = [];
        if ($request->tags) {
            foreach ($request->tags as $k => $v) {
                if (!is_numeric($v)) {
                    $tag = Tag::create(['title' => $v]);
                    array_push($tags, $tag->id);
                } else {
                    array_push($tags, $v);
                }
            }
        }
        $deal->tags()->sync($tags);
        return $deal;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $deal = Deal::with('tags')->find($id);
        $tags = Tag::pluck('title', 'id')->all();
        $users = User::pluck('name', 'id')->all();
        if ($deal->user_id != auth()->user()->id){
            $dealUser = DealUser::where([
                ['user_id', auth()->user()->id],
                ['permission_id', '>', 1],
                ['deal_id', $id],
            ])->select('deal_id')->get();
            if (count($dealUser) > 0){
                return view('deals.edit', compact('deal', 'tags'));
            }else{
                return view('deals.view', compact('deal', 'tags'));
            }
        }
        return view('deals.edit', compact('deal', 'tags', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $deal = Deal::find($id);
        $data = $request->all();
        if (isset($request->users) && isset($request->permission)){
            $dealUsers = DealUser::where('deal_id', $id)->WhereIn('user_id', $request->users)->get();
            foreach ($dealUsers as $dealUser){
                $dealUser->delete();
            }
            foreach ($request->users as $user){
                $item = new DealUser();
                $item->fill(['user_id' => $user, 'deal_id' => $id, 'permission_id' => $request->permission]);
                $item->save();
            }
        }

        if ($file = Deal::uploadImage($request, $deal)) {
            $data['thumbnail'] = $file['thumbnail'];
            $data['preview_img'] = $file['preview_img'];
        }

        $tags = [];
        if ($request->tags){
            foreach ($request->tags as $k => $v) {
                if (!is_numeric($v)) {
                    $tag = Tag::create(['title' => $v]);
                    array_push($tags, $tag->id);
                } else {
                    array_push($tags, $v);
                }
            }
        }

        $deal->tags()->sync($tags);
        $deal->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
