<div class="text-center font-bold">UAB „EKOMETRIJA“</div>
<div class="text-center mt-4">Geologų g. 11,  Vilnius, tel.  8 5 213 67 30, el. p. info@ekometrija.lt</div>

<table class="w-full border mt-8">
    <thead>
    <tr>
        <th class="border align-top p-2">Nr.</th>
        <th class="border align-top p-2">Darbai</th>
        <th class="border align-top p-2">Atlikti iki</th>
        <th class="border align-top p-2">Pastabos 1</th>
        <th class="border align-top p-2">&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tasks as $task)
        <?php
        $due_date = $task->due_date;

        if ( !empty($task->requiring_int) ) {
            $due_date = $task->requiring_int;
        }
        ?>
        <tr>
            <td class="border align-top p-2">{{ $task->id }}</td>
            <td class="border align-top p-2">{{ $task->name }}</td>
            <td class="border align-top p-2">{{ $due_date }}</td>
            <td class="border align-top p-2">{{ $task->notes_1 }}</td>
            <td class="border align-top p-2"></td>
        </tr>
    @endforeach
    </tbody>
</table>
