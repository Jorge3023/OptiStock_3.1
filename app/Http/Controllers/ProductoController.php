<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'ilike', "%{$search}%")
                  ->orWhere('codigo_barras', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $productos = $query->orderBy('created_at', 'desc')->get();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $estado = ($request->stock <= 0) ? 'Sin existencia' : 'Disponible';

        $producto = Producto::create([
            'nombre'        => $request->nombre,
            'codigo_barras' => $request->codigo_barras,
            'stock'         => $request->stock,
            'precio'        => $request->precio,
            'creado_por'    => Auth::user()->name,
            'cargo'         => Auth::user()->cargo,
            'estado'        => $estado,
        ]);

        DB::table('cambios_productos')->insert([
            'producto_id'    => $producto->id,
            'producto_nombre'=> $producto->nombre,
            'accion'         => 'creado',
            'usuario'        => Auth::user()->name,
            'detalle'        => "Producto creado con stock {$producto->stock} y precio \${$producto->precio}",
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $estado = ($request->stock <= 0) ? 'Sin existencia' : 'Disponible';

        $cambios = [];
        if ($producto->nombre  !== $request->nombre)        $cambios[] = "nombre: '{$producto->nombre}' → '{$request->nombre}'";
        if ($producto->precio  != $request->precio)         $cambios[] = "precio: \${$producto->precio} → \${$request->precio}";
        if ($producto->stock   != $request->stock)          $cambios[] = "stock: {$producto->stock} → {$request->stock}";
        if ($producto->cargo   !== $request->cargo)         $cambios[] = "cargo: '{$producto->cargo}' → '{$request->cargo}'";
        if ($producto->estado  !== $estado)                 $cambios[] = "estado: '{$producto->estado}' → '{$estado}'";

        $producto->update([
            'nombre'        => $request->nombre,
            'codigo_barras' => $request->codigo_barras,
            'stock'         => $request->stock,
            'precio'        => $request->precio,
            'cargo'         => $request->cargo,
            'estado'        => $estado,
        ]);

        DB::table('cambios_productos')->insert([
            'producto_id'    => $producto->id,
            'producto_nombre'=> $producto->nombre,
            'accion'         => 'editado',
            'usuario'        => Auth::user()->name,
            'detalle'        => count($cambios) ? implode(', ', $cambios) : 'Sin cambios detectados',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        DB::table('cambios_productos')->insert([
            'producto_id'    => $producto->id,
            'producto_nombre'=> $producto->nombre,
            'accion'         => 'eliminado',
            'usuario'        => Auth::user()->name,
            'detalle'        => "Producto eliminado (stock era: {$producto->stock})",
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado.');
    }

    public function cambios()
    {
        $cambios = DB::table('cambios_productos')
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get();
        return view('productos.cambios', compact('cambios'));
    }
}