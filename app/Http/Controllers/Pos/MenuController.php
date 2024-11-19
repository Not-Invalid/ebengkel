<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    // public function index()
    // {
    //     $menus = Menu::where('is_delete', 'N')->get();  // Menampilkan menu yang tidak dihapus
    //     return view('menu.index', compact('menus'));
    // }

    // // Menampilkan form untuk membuat menu baru
    // public function create()
    // {
    //     return view('menu.create');
    // }

    // // Menyimpan menu baru ke database
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'nama_menu' => 'required|string|max:30',
    //         'link_menu' => 'nullable|url',
    //         'icon_menu' => 'nullable|string|max:50',
    //         'menu_type' => 'nullable|string|max:20',
    //         'parent_id_1' => 'nullable|integer',
    //         'parent_id_2' => 'nullable|integer',
    //         'parent_id_3' => 'nullable|integer',
    //     ]);

    //     Menu::create([
    //         'nama_menu' => $request->nama_menu,
    //         'link_menu' => $request->link_menu,
    //         'icon_menu' => $request->icon_menu,
    //         'menu_type' => $request->menu_type,
    //         'parent_id_1' => $request->parent_id_1,
    //         'parent_id_2' => $request->parent_id_2,
    //         'parent_id_3' => $request->parent_id_3,
    //         'menu_position' => $request->menu_position,
    //         'input_by' => auth()->user()->name,
    //         'input_date' => now(),
    //     ]);

    //     return redirect()->route('menu.index')->with('success', 'Menu berhasil dibuat');
    // }

    // // Menampilkan form untuk mengedit menu
    // public function edit($id)
    // {
    //     $menu = Menu::findOrFail($id);
    //     return view('menu.edit', compact('menu'));
    // }

    // // Mengupdate menu yang ada
    // public function update(Request $request, $id)
    // {
    //     $validated = $request->validate([
    //         'nama_menu' => 'required|string|max:30',
    //         'link_menu' => 'nullable|url',
    //         'icon_menu' => 'nullable|string|max:50',
    //         'menu_type' => 'nullable|string|max:20',
    //         'parent_id_1' => 'nullable|integer',
    //         'parent_id_2' => 'nullable|integer',
    //         'parent_id_3' => 'nullable|integer',
    //     ]);

    //     $menu = Menu::findOrFail($id);
    //     $menu->update([
    //         'nama_menu' => $request->nama_menu,
    //         'link_menu' => $request->link_menu,
    //         'icon_menu' => $request->icon_menu,
    //         'menu_type' => $request->menu_type,
    //         'parent_id_1' => $request->parent_id_1,
    //         'parent_id_2' => $request->parent_id_2,
    //         'parent_id_3' => $request->parent_id_3,
    //         'menu_position' => $request->menu_position,
    //         'update_by' => auth()->user()->name,
    //         'update_date' => now(),
    //     ]);

    //     return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui');
    // }

    // // Menghapus menu
    // public function destroy($id)
    // {
    //     $menu = Menu::findOrFail($id);
    //     $menu->update([
    //         'is_delete' => 'Y',
    //         'delete_by' => auth()->user()->name,
    //         'delete_date' => now(),
    //     ]);

    //     return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus');
    // }
}
