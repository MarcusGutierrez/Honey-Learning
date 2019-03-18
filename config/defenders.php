<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Best Response
    |--------------------------------------------------------------------------
    |
    | Best Response specific parameters to be defined in the .env file.
    |
    |
    */

    'br_path' => env('BR_PATH', './'),
    
    'br_lookahead' => env('BR_LOOKAHEAD', 1),
    
    'br_sampledstates' => env('BR_SAMPLEDSTATES', 2000),
    
    /*
    |--------------------------------------------------------------------------
    | Probabilistic Best Response
    |--------------------------------------------------------------------------
    |
    | Best Response specific parameters to be defined in the .env file.
    |
    |
    */

    'pbr_path' => env('PBR_PATH', './'),
    
    'pbr_lookahead' => env('PBR_LOOKAHEAD', 1),
    
    'pbr_sampledstates' => env('PBR_SAMPLEDSTATES', 2000),

    /*
    |--------------------------------------------------------------------------
    | Follow the Regularized Leader
    |--------------------------------------------------------------------------
    |
    | Initial parameters for the Follow The Regularized Leader defender
    | algorithm with Tsallis Entropy and Shannon's Entropy for regularizers.
    | All parameters should be defined in the .env file. In the future, I
    | should derive the base prameters, D and M from the game instead of
    | hardcoded in the .env file.
    |
    */

    'ftrl_d' => env('FTRL_D', 5), //The total number of basic arms to select

    'ftrl_d' => env('FTRL_M', 2), //The average number of basic arms to select
    
    'ftrl_eps' => env('FTRL_EPS', 1.0), //Error epsilon
    
    'ftrl_gamma' => env('FTRL_GAMMA', 2), //Not quite sure it's effect

];
