<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-xl uppercase mb-5">
                        {{ __("webSites Url") }}
                    </h2>
                    <br>
                    <br>
                    <div style="display: flex; justify-content: center; align-items: center;">
                        <form action="{{ route('scraper-data.store') }}" method="post">
                            @csrf
                            <div style="margin-bottom: 15px;">
                                <label for="">Enter Web Page Url</label>
                                <br>
                                <input type="text" name="url[]" class="form-control"
                                       placeholder="https://www.example.com">
                                <button onclick="addInput()" type="button" style="padding: 10px; background-color: green; color: #fff">
                                    Add
                                </button>
                            </div>
                            <span id="rowData"></span>

                            <button type="submit" style="padding: 10px; background-color: #2563eb; color: #fff; float: right">
                                Scrap Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let i = 0;
        function addInput(){
            i++;
            let inputAdd = `
                <div id="row_`+i+`" style="margin-bottom: 15px;">
                    <label for="">Enter Web Page Url</label>
                    <br>
                    <input type="text" name="url[]" class="form-control"
                           placeholder="https://www.example.com">
                    <button onclick="removeInput('row_`+i+`')" type="button" style="padding: 10px; background-color: #ef4444; color: #fff">
                        Delete
                    </button>
                </div>
            `;
            $("#rowData").append(inputAdd);
        }

        function removeInput(id){
            $('#'+id).remove();
        }
    </script>
</x-app-layout>
