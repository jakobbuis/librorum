<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Notebook;
use App\Page;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrashController extends Controller
{
    /**
     * Show all contents of the trash
     */
    public function index()
    {
        return \App\Http\Resources\TrashItem::collection($this->trashedItems());
    }

    /**
     * Restore an item by patching it
     */
    public function update(Request $request, string $id)
    {
        $item = $this->findItem($id);
        if (!$item) {
            abort(404);
        }

        if (!$item->owner->is(Auth::user())) {
            abort(403);
        }

        if ($request->has('deleted_at')) {
            $item->deleted_at = $request->get('deleted_at');
            $item->save();
        }

        return response(null, 204);
    }

    /**
     * DELETE /trash empties the trash
     */
    public function purge()
    {
        foreach ($this->trashedItems() as $item) {
            $item->forceDelete();
        }
        return response(null, 204);
    }

    /**
     * Find all trashed objects
     * @return \Illuminate\Support\Collection
     */
    private function trashedItems()
    {
        $tags = Tag::ownedBy(Auth::user())->onlyTrashed()->get();
        $pages = Page::ownedBy(Auth::user())->onlyTrashed()->get();
        $notebooks = Notebook::ownedBy(Auth::user())->onlyTrashed()->get();

        return $tags->union($pages)->union($notebooks)->sortBy('deleted_at')->values();
    }

    /**
     * Find an object based off it UUID
     * @param  string $id full UUID
     * @return \App\Model
     */
    private function findItem(string $id)
    {
        $tag = Tag::ownedBy(Auth::user())->onlyTrashed()->find($id);
        if ($tag) {
            return $tag;
        }

        $page = Page::ownedBy(Auth::user())->onlyTrashed()->find($id);
        if ($page) {
            return $page;
        }

        $notebook = Notebook::ownedBy(Auth::user())->onlyTrashed()->find($id);
        if ($notebook) {
            return $notebook;
        }

        return null;
    }
}
