<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Empleados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class EmpleadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['empleados']=Empleados::paginate(5);
        return view('empleados.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('empleados.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //metodo para agregar empleado...

    public function store(Request $request)
    {           //.. Personalizacion de mensajes..
        $mensaje=['required'=>'El :attribute es requerido',
            'Foto.required'=>' La :attribute es requerida',
            'Correo.unique' => 'Este :attribute, ya ha sido asignado a otra persona',
            'max' => 'Se excedió la longitud máxima de caracteres para :attribute',
            'mimes' => 'La :attribute posee un formato incorrecto, solo acepta formato "jpeg, png ó jpg.',
        ];

//.Advertencia: las "mayusculas" dentro del nombre de variables sirve de separador en el atributo
                  //para mostrar errores..

    $request->validate([
        'Nombre' => ['required', 'string', 'max:100'],
        'ApellidoPaterno' => ['required', 'string', 'max:100'],
        'ApellidoMaterno' => ['required', 'string', 'max:100'],
        'Correo' => ['required', 'unique:empleados', 'email'],
        'Foto' => ['required', 'max:10000', 'mimes:jpeg,png,jpg'],
    ],$mensaje);
      //.........................................................
      //....Esta forma es equivalente...
      //   $campos=[
      //       'Nombre' => 'required|string|max:100',
      //       'ApellidoPaterno' => 'required|string|max:100',
      //       'ApellidoMaterno' => 'required|string|max:100',
      //       'Correo' => 'required|email',
      //       'Foto' => 'required|max:10000|mimes:jpeg,png,jpg'
      //   ];
      // //Definir el mensaje generico, mas el del atributo especifico "Foto"..
        // $mensaje=['required'=>'El :attribute es requerido',
        //           'Foto.required'=>' La :attribute es requerida'
        // ];

      //   $this->validate($request, $campos, $mensaje);
        //<-agregar empleado
        //$datosEmpleado=request()->all();

    //...Cambio de nombre de las variables para adecuarlas a las de las BD...
        $a['nombre']=request('Nombre');
        $a['apellidopater']=request('ApellidoPaterno');
        $a['apellidomater']=request('ApellidoMaterno');
        $a['correo']=request('Correo');
        $a['foto']=request('Foto');

        //$datosEmpleado=request()->except('_token');

        //return Response()->json($a);
        if ($request->hasFile('Foto')) {

            $a['foto']=$request->file('Foto')->store('uploads', 'public');

        }

        Empleados::insert($a);
        //..>

        //return Response()->json($datosEmpleado);
        //redireccionado con paso de variable para imprimir mensaje..
        return redirect('empleados')->with('Mensaje','Empleado agregado con éxito');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function show(Empleados $empleados)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $empleado= empleados::findOrFail($id);
        return view('empleados.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $campos=[
        'Nombre' => 'required|string|max:100',
        'ApellidoPaterno' => 'required|string|max:100',
        'ApellidoMaterno' => 'required|string|max:100',
        'Correo' => 'required|email'
        ];

        //...Cambio de nombre de las variables para adecuarlas a las de las BD...
        $a['nombre']=request('Nombre');
        $a['apellidopater']=request('ApellidoPaterno');
        $a['apellidomater']=request('ApellidoMaterno');
        $a['correo']=request('Correo');
        

        if ($request->hasFile('Foto')) {

            $campos+=['Foto' => 'required|max:10000|mimes:jpeg,png,jpg'];
            $a['foto']=request('Foto');

        }
      //Definir el mensaje generico, mas el del atributo especifico "Foto"..
        $mensaje=[
            'required'=>'El :attribute es requerido',
            'Foto.required'=>' La :attribute es requerida',
            'max' => 'Se excedió la longitud máxima de caracteres para :attribute',
            'mimes' => 'La :attribute posee un formato incorrecto, solo acepta formato "jpeg, png ó jpg.',
        ];

        $this->validate($request, $campos, $mensaje);

                //solo actualiza foto..
        //$datosEmpleado=request()->except(['_token','_method']);

          if ($request->hasFile('Foto')) {

            $empleado= empleados::findOrFail($id);

            Storage::delete('public/'.$empleado->foto);

            $a['foto']=$request->file('Foto')->store('uploads', 'public');

        }


        //actualizacion de datos en general..
         empleados::where('id','=',$id)->update($a);

         //$empleado= empleados::findOrFail($id);
         //return view('empleados.edit', compact('empleado'));
         return redirect('empleados')->with('Mensaje','El empleado se modifico con éxito');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empleados  $empleados
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $empleado= empleados::findOrFail($id);

        if (Storage::delete('public/'.$empleado->foto)) {

            Empleados::destroy($id);
        };

        
        return redirect('empleados')->with('Mensaje','El empleado fue eliminado');

    }
}
