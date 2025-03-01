<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('auth:purge-tokens')->daily();
