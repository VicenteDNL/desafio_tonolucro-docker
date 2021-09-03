@extends('base')
@section('content')

    <div class="d-flex align-content-stretch flex-wrap">
        @forelse ($restaurantes as $restaurante)
            <div class="card text-center  m-2" style="width: 22rem;">
                <div class="card-body pb-1 d-flex flex-column">
                    <h5 class="card-title mb-0">{{$restaurante['nome']}} </h5>
                    <small class="mb-3 text-muted fw-light">
                        @if ($restaurante['telefone']!=null)
                             <i class="fas fa-phone-alt"></i>
                            {{"(".substr($restaurante['telefone'],0,2).") ".substr($restaurante['telefone'],2,-4)."-".substr($restaurante['telefone'],-4)}}
                        @else
                            sem telefone
                        @endif
                    </small>
                    <hr class="text-warning mt-0 ">
                    <div class="flex-grow-1 mb-3  d-flex align-items-center justify-content-center">
                        <p class="card-text">{{$restaurante['descricao']}}</p>
                    </div>
                    <div class="text-muted fw-light">
                        <span>
                            @if ($restaurante['cidade']!=null && $restaurante['estado']!=null)
                                <i class="fas fa-map-marker-alt"></i>
                                {{$restaurante['cidade']}} -{{$restaurante['estado']}}
                            @else
                                sem endereço
                            @endif
                         </span>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <a href="{{route('cardapios.index', ['id'=>$restaurante['id']])}}" class="btn btn-sm btn-dark">
                        <i class="fas fa-eye mr-2"></i>
                        Ver Cardápios
                    </a>
                </div>
            </div>
        @empty
            <div class="d-flex  justify-content-center" style="width: 100%">
                <span class="text-muted">nenhum restaurante</span>
            </div>

        @endforelse
    </div>
@endsection
