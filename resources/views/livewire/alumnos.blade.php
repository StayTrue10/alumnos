<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Alumnos</h2>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if(session()->has('message'))
                <div class="bg-red-500 text-white rounded-b px-4 py-4 shadow-md my-3" role="alert">
                    <div class="flex">
                        <div>
                            <h4>{{ session('message')}}</h4>
                        </div>
                    </div>
                </div>
            @endif
            <button wire:click="crear()" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 my-3" >Nuevo</button>
            @if($modal)
                @include('livewire.crear')
            @elseif($asis)
                @include('livewire.asistencia')
            @endif
            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-red-400 text-white">
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Edad</th>
                        <th class="px-4 py-2">Grupo</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alumnos as $alumno)
                    <tr>
                        <td class="border px-4 py-2">{{$alumno->nombre}}</td>
                        <td class="border px-4 py-2">{{$alumno->edad}}</td>
                        <td class="border px-4 py-2">{{$alumno->grupo}}</td>
                        <td class="border px-4 py-2 text-center">
                            <button wire:click="asistencia({{$alumno->id}})" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4">Asistencia</button>
                            <button wire:click="editar({{$alumno->id}})" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4">Editar</button>
                            <button wire:click="borrar({{$alumno->id}})" class="mt-1 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4">Borrar</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>