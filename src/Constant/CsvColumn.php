<?php

declare(strict_types=1);

namespace App\Constant;

class CsvColumn
{
    final public const CNUMNUTS_NUMNUTS = 0;

    final public const CNUMNUTS_NUTS = 1;

    final public const CNUMNUTS_NAZEVNUTS = 2;

    final public const CNUMNUTS_KODCIS = 3;

    final public const PSCOCO_KRAJ = 0;

    final public const PSCOCO_OKRES = 1;

    final public const PSCOCO_CPOU = 2;

    final public const PSCOCO_ORP = 3;

    final public const PSCOCO_OBEC = 4;

    final public const PSCOCO_NAZEVOBCE = 5;

    final public const PSCOCO_VOLKRAJ = 6;

    final public const CISOB_OBEC_PREZ = 0;

    final public const CISOB_NAZEVOBCE = 1;

    final public const CVS_VSTRANA = 0;

    final public const CVS_NAZEVCELK = 1;

    final public const CVS_ZKRATKAV8 = 4;

    final public const PSRKL_KSTRANA = 0;

    final public const PSRKL_NAZEVCELK = 2;

    final public const PSRKL_NAZEV_STRK = 3;

    final public const PSRKL_ZKRATKAK30 = 4;

    final public const PSRKL_ZKRATKAK8 = 5;

    final public const PSRKL_POCSTRVKO = 0;

    final public const T4_OBEC = 5;

    final public const T4_OKRSEK = 6;

    final public const T4_PL_HL_CELK = 13;

    final public const T4P_OBEC = 5;

    final public const T4P_OKRSEK = 6;

    final public const T4P_KSTRANA = 8;

    final public const T4P_POC_HLASU = 9;

    final public const COLUMNS_FILTER_T4 = [
        self::T4_OBEC,
        self::T4_OKRSEK,
        self::T4_PL_HL_CELK,
    ];

    final public const COLUMNS_FILTER_T4P = [
        self::T4P_OBEC,
        self::T4P_OKRSEK,
        self::T4P_KSTRANA,
        self::T4P_POC_HLASU,
    ];
}
