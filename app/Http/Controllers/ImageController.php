<?php

namespace App\Http\Controllers;
//librerias
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
//modelos
use App\Models\Image;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.verify'); // Protección de rutas por JWT
    }

    // Leer todas las imágenes de un usuario
    public function index(Request $request)
    {
        //obtener las imagenes
        $query = Image::query();

        // Buscar por título o descripción si se pasa un parámetro 'search'
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('user_id', Auth::id())
                ->where('title', 'LIKE', "%{$search}%");
        }

        // Paginación: Obtener imágenes con un límite por página
        $images = $query->where('user_id', Auth::id())->paginate(8);  // Aquí definimos que queremos 8 imágenes por página
        // enviar imagenes paginadas
        return response()->json($images);
    }
    
    //mostrar imagen
    public function viewImage($id)
    {
        //obtener la imagen
        $image = Image::findOrFail($id);

        // Verificar que el usuario autenticado sea el propietario de la imagen
        if ($image->user_id !== Auth::id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        // Proveer el archivo de la imagen desde la ubicación privada
        if (Storage::exists($image->image_path)) {
            return response()->download(Storage::path($image->image_path));
        }

        // respuesta de error
        return response()->json(['message' => 'Imagen no encontrada'], 404);
    }

    //cargar datos de la imagen a editar
    public function show($id)
    {
        //obtener la imagen
        $image = Image::find($id);
        //validar que exista la imagen
        if (!$image) {
            return response()->json(['message' => 'Imagen no encontrada'], 404);
        }
        //enviar datos de imagen
        return response()->json($image);
    }


    // Crear una imagen
    public function store(Request $request)
    {
        //validar campos
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,gif|max:2048',
            'title' => 'required|max:200',
            'description' => 'required',
        ]);

        //obtener imagen del formulario
        $image = $request->file('image');
        $imageName = Str::random(10) . '.' . $image->getClientOriginalExtension();
        
        // Almacenar la imagen en el disco 'private'
        $imagePath = $image->storeAs('private/images', $imageName);

        // Guardar la información de la imagen en la base de datos
        $imageRecord = Image::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'user_id' => Auth::id(),
        ]);

        //enviar respuesta
        return response()->json($imageRecord, 201);
    }

    // Actualizar una imagen
    public function update(Request $request, $id)
    {
        //obtener datos de la imagen
        $image = Image::findOrFail($id);        

        // Actualizar la base de datos con la nueva información
        $image->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        //enviar respuesta
        return response()->json($image, 200);
    }

    // Eliminar una imagen
    public function destroy($id)
    {
        //obtener datos de la imagen
        $image = Image::findOrFail($id);

        // Eliminar el archivo de la imagen en el servidor
        if (Storage::exists($image->image_path)) {
            Storage::delete($image->image_path);
        }

        //eliminar registro de imagen
        $image->delete();

        //enviar mensaje de respuesta
        return response()->json(['message' => 'Imagen eliminada con éxito'], 200);
    }
}
