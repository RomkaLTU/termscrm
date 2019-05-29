@extends('layouts.pdf')

@section('content')
    <div class="text-center font-bold">UAB „EKOMETRIJA“</div>
    <div class="text-center mt-4">Geologų g. 11,  Vilnius, tel.  8 5 213 67 30, el. p. info@ekometrija.lt</div>
    <div class="text-center font-bold mt-2">MĖGINIŲ PAĖMIMO  PROTOKOLAS  Nr. _________</div>

    <div class="mt-4">
        <div class="mb-2">
            <div class="inline-block w-64">Mėginių paėmimo data:</div>
            <div class="inline-block">20______m &nbsp;&nbsp;&nbsp; mėn. ______d.</div>
        </div>
        <div>
            <div class="inline-block w-64">Pristatymo data:</div>
            <div class="inline-block">20______m &nbsp;&nbsp;&nbsp; mėn. ______d.</div>
        </div>
    </div>

    <div class="mt-6">
        <div class="mb-4">
            <div class="inline-block">Mėginį paėmė:</div>
            <div class="inline-block relative h-6 ml-2 user-input" style="width: 422px;">
                <div class="text-xs absolute bottom-0 left-0 ml-40 -mb-5 text-center">(v.,pavardė,parašas)</div>
            </div>
        </div>
        <div class="mb-4">
            <div class="inline-block">Mėginį pristatė:</div>
            <div class="inline-block relative h-6 ml-2 user-input" style="width: 422px;">
                <div class="text-xs absolute bottom-0 left-0 ml-40 -mb-5 text-center">(v.,pavardė,parašas)</div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <div class="inline-block">Užsakovas, adresas:</div>
        <div class="inline-block relative w-2/3 h-6 ml-2 user-input" style="width: 648px;">
            {{ $tasks[0]->contract->customer }}, {{ $tasks[0]->contract->customer_address }}
        </div>
    </div>

    <div class="mt-4">
        <div class="inline-block">Objektas, adresas, atsakingas asmuo, vardas, pavardė, tel.:</div>
        <div class="inline-block user-input h-6" style="width: 422px;">
            {{ $tasks[0]->obj->details }}
        </div>
        <div class="user-input h-8" style="width: 100%;"></div>
    </div>

    <div class="mt-6">
        <div class="inline-block">Transportavimo sąlygos:</div>
        <div class="inline-block user-input ml-2 h-6" style="width: 634px;"></div>
    </div>

    <div class="mt-6">
        <div class="flex justify-start">
            <div class="w-64">Mėginio paėmimo, ND:</div>
            <div class="flex-1">
                <div class="h-full text-xs">
                    ND: LST EN ISO 5667-3, NT-  LST EN ISO 5667-10, LT- LST EN ISO 5667-14, PV-LST EN ISO 5667-6,14; ISO 5667-4, PŽ- LST EN ISO 5667-11, GV-LST EN ISO 5667-5, LST EN ISO 19458; D- LST EN ISO 5667-13,15; GD- LST ISO 10381-4,5,6
                </div>
            </div>
        </div>
    </div>

    <table class="w-full border mt-8">
        <thead>
        <tr>
            <th colspan="5" class="border">Mėginio</th>
            <th colspan="5" rowspan="2" class="borde">*Indai, Nr.</th>
        </tr>
        <tr>
            <th class="border align-top p-2">registracijos Nr.</th>
            <th class="border align-top p-2">** rūšis</th>
            <th class="border align-top p-2">paėmimo vieta, nustatomos analitės</th>
            <th class="border align-top p-2">laikas</th>
            <th class="border align-top p-2">T,0C</th>
        </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td class="border align-top p-2"></td>
                <td class="border align-top p-2"></td>
                <td class="border align-top p-2">{{ $task->name }} {{ implode(', ', $task->taskParams->pluck('name')->toArray()) }}</td>
                <td class="border align-top p-2"></td>
                <td class="border align-top p-2"></td>
                <td class="border align-top p-2 w-40">{{ implode(', ', $task->paramGroups->pluck('id')->toArray()) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        <div class="inline-block">*Mėginio kiekis, l (žymėjimai):</div>
        <div class="inline-block text-xs">
            1(pH, BDS, NO2, SM,Cl,Cr (VI),spalva,SEL,F,SO4,,K,Na,APAM,Nej.PAM-nekons.) - 2l,2(ChDS,PI,azotas,NH4,BOC-kons.H2SO4) -1l, 3(BP, PO4,B,Ca,kietumas-kons.HNO3) -0,5l, 4(Fe, NO3-kons.HCl) -0,2l ,5ME(Sunkieji metalai-kons.HNO3) - 0,05l, 6Hg(gyvsidabris -kons.HCl) -0,03l , 7LA(lengvieji aromat. angliavand., Halogeninti aromat. angliavand., aromat. angliavand. -nekons.)-0,1l ,8 DAA (daugiacikliai aromat. angliavand.-nekons.) -0,5l , 9Pest.(Pesticidai-nekons.) -1,0l ,10 CN(Cianidai-kons. NaOH) -0,1l ,11 NP,NPch (naftos produk.,naftos angliavand. indeksas-kons.HCl)-0,9l,  12FT(ftalatai-nekons.)-1,0l, 13M(e.coli,koliform., ž.enterokok., KSV-nekons.)-0,5l,14L,S(legionelės,salmonelės-nekons.)-1,0l.
        </div>
    </div>

    <div class="mt-4">
        <div class="inline-block">**Mėginio rūšis:</div>
        <div class="inline-block text-xs">
            NT-nuotekos, LT- paviršinės (lietaus)nuotekos, PV -paviršinis vanduo, PŽ-požeminis vanduo, GV- geriamasis vanduo,
            GD - dumblas, gruntas,dirvožemis, KT-atliekos,kompostas, gamybinis vanduo, kt.
        </div>
    </div>

    <div class="mt-6">
        <div class="inline-block">Užsakovo atstovas:</div>
        <div class="inline-block ml-2">
            <div class="inline-block relative h-6 ml-2 user-input" style="width: 422px;">
                <div class="text-xs absolute bottom-0 left-0 ml-40 -mb-5 text-center">(v.,pavardė,parašas)</div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <div class="inline-block">Pastabos:</div>
        <div class="inline-block ml-2">
            <div class="inline-block relative h-6 ml-2 user-input" style="width: 715px;"></div>
        </div>
    </div>
@stop
