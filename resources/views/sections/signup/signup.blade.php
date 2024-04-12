@include('layouts.head',['titulo' => 'Giving-Land - Registro'])
</head>
<body class="bg-white">
    <x-header class="pl-5"/>
    <div class="flex justify-center pt-12 pb-5">
        @include('sections.div-form',[
            'titulo' => $titulo,
            'rutaSiguiente' => $rutaSiguiente,
            'yield' => $yield
        ])
    </div>
    @session('code')
        <script src={{asset('js/signup/code.js')}}></script>
    @endsession
@include('layouts.foot')