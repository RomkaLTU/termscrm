<?php

Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Pagrindinis', route('dashboard'));
});

Breadcrumbs::for('users', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Vartotojai', route('users.index'));
});
