@extends('layouts.main')

@section('title', 'Strona główna')

@section('content')



    <wyswigPanel>
        <h1 class='wyswig'>To jest strona główna</h1>
    </wyswigPanel>

    <p>Treść strony.</p>

    @if(!empty($Element_Structure_variables['testowy']))
        @foreach($Element_Structure_variables['testowy'] as $element)
            <wyswigElement>
                {{ $element['value'] }}
            </wyswigElement>
        @endforeach
    @else
        <p>Brak elementów</p>
    @endif

    <script>
        var new_values = @json($Element_Structure_variables);
        var original_values = @json($Element_Structure_variables_original);
        // console.log(new_values['testowy'])
        // if(new_values['testowy']){
        //     new_values['testowy'].pop();
        // }

        // new_values['testowy'][0]['value'] = 'cos nowego';
        // new_values['testowy'].push({
        //     dev_name: 'testowy',
        //     value: 'Nowy element'
        // });

        if (JSON.stringify(new_values) !== JSON.stringify(original_values)) {
            const diff = compareStructures(original_values, new_values);

            fetch('/seeChanges', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ Changes: diff })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Błąd: ${response.statusText} (status: ${response.status})`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Odpowiedź serwera:', data);
            })
            .catch(error => {
                console.error('Wystąpił błąd:', error);
                alert('Wystąpił problem podczas próby wysłania danych. Proszę spróbować ponownie.');
            });
        }

        function compareStructures(original, updated) {
            let changes = {
                added: [],
                removed: [],
                modified: []
            };

            const allKeys = new Set([
                ...Object.keys(original),
                ...Object.keys(updated)
            ]);

            allKeys.forEach(key => {
                const origList = original[key] || [];
                const updatedList = updated[key] || [];

                const origMap = Object.fromEntries(origList.map(item => [item.id, item]));
                const updatedMap = Object.fromEntries(updatedList.map(item => [item.id, item]));

                for (const [id, updatedItem] of Object.entries(updatedMap)) {
                    if (!origMap[id]) {
                        changes.added.push({ key, item: updatedItem });
                    } else if (updatedItem.value !== origMap[id].value) {
                        changes.modified.push({ id, value: updatedItem.value });
                    }
                }

                for (const [id, origItem] of Object.entries(origMap)) {
                    if (!updatedMap[id]) {
                        changes.removed.push({ id });
                    }
                }
            });
            return changes;
        }
    </script>

    @include('partials.slider')

@endsection
