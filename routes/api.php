<?php

Route::resource('clients', 'ClientController')->except(['edit', 'create']);
