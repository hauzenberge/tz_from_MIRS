@extends('layouts.app')

@section('content')

<div class="container">
    <div class="panel-body">
        <div class="col-sm-10">
            <div id="app">
                <form action="#">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="cities">{{ $lables['select_city'] }} </label>
                        <select id="cities" lass="form-select" v-model="city">
                            @if($cities)
                            @foreach ($cities as $city)
                            <option value="{{ $city['name'] }}">{{ $city['name'] }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group" v-if="city">
                        <label for="departement" v-if="ms_departements.data.length > 0">{{ $lables['select_departament'] }} </label>
                        <select class="form-select" id="departement" v-model="departement" v-if="ms_departements.data.length > 0">
                            <option v-for="option in ms_departements.data" v-bind:value="option.name">
                                @{{ option.name }}
                            </option>
                        </select>
                        <strong v-if="ms_departements.data.length == 0"> {{ $lables['departement_not_found'] }} </strong>
                    </div>

                    <div class="form-group" v-if="departement">
                        <label for="summa">{{ $lables['enter_price'] }} </label>
                        <input type="number" class="form-control" v-model="summa">
                    </div>

                    <div class="form-group" v-if="summa">
                        <label>{{ $lables['count'] }} </label>
                        <strong>@{{ count }} UAH</strong>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/vue@2.7.14/dist/vue.js"></script>

<script>
    new Vue({
        el: '#app',
        data: {

            city: '',
            departement: '',
            ms_departements: '',
            summa: '',
            count: '',

            url: '{{ $url }}',
            lang: '{{ $lang }}',
        },
        watch: {
            city: function(newVal, oldVal) {
                console.log(newVal);
                this.ms_departements = axios
                    .post(this.url + '/serchDepartement', {
                        params: {
                            cityName: newVal,
                            lang: this.lang
                        }
                    })
                    .then(response => (this.ms_departements = response));
            },
            summa: function(newVal, oldVal) {
                console.log(newVal);
                if (newVal <= 1000) {
                    this.count = Number(newVal) + 50 + (Number(newVal) * 50) / 100;
                } else if ((newVal > 1000) &&
                    (newVal < 3000)) {
                    this.count = Number(newVal) + 50 + (Number(newVal) * 50) / 100
                }else if(newVal >= 3000) {
                    this.count = 0;
                }
            }
        },
        mounted() {
            console.log(this.url);
            console.log(this.lang);
        }
    })
</script>
@endsection