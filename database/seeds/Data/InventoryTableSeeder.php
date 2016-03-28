<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InventoryTableSeeder extends Seeder {

    public function run(){

        DB::table('inventories')->delete();
        DB::insert("INSERT INTO inventories (serialnr, name, category_id, user_id, metric_id) VALUES
        ('4505354484 KC725M', 'Kenna Special', 14,  1, 1),
        ('4505354484 KC725M Dub', 'Kenna Special', 14,  1, 1),
        ('DFR030204GD   KC7140', 'Drilling insert', 13,  1, 1),
        ('DFT05T308HP   KC7140', 'Drilling insert', 13,  1, 1),
        ('DFT05T308HP   KC7215', 'Drilling insert', 13,  1, 1),
        ('DFT05T308HP   KCU40', 'Drilling insert', 13,  1, 1),
        ('DFT070408HP   KC7215', 'Drilling insert', 13,  1, 1),
        ('DFT070408MD   KC7140', 'Drilling insert', 13,  1, 1),
        ('DNMG 15 06 08FF    KT315', 'Turning Insert', 2,  1, 1),
        ('DNMG 15 06 08MR    KCM15B', 'Turning Insert', 2,  1, 1),
        ('EDCT140408PDERGD KC725M', 'Milling insert', 3,  1, 1),
        ('EDCT140408PDERLD KC522M', 'Milling insert', 3,  1, 1),
        ('EDCT140408PDFRLDJ KC410M', 'Milling insert', 3,  1, 1),
        ('EDCT180508PDFRLDJ KC410M', 'Milling insert', 3,  1, 1),
        ('LNGU15T612ERGE    KC725M', 'Mill4 Insert R1.2', 3,  1, 1),
        ('RNGN120400EGN    KYS30', 'Negative Ceramic', 3,  1, 1),
        ('RNGN120700E    KY1540', 'Kendex Negative Ceramic', 3,  1, 1),
        ('RPGN120400E    KYS30', 'Kendex Negative Ceramic', 3,  1, 1),
        ('SPPX09T310HP   KCU25', 'Drilling insert', 13,  1, 1),
        ('SPPX09T310MD   KCU25', 'Drilling insert', 13,  1, 1),
        ('SPPX09T310MD   KCU40', 'Drilling insert', 13,  1, 1),
        ('VBMT 16 04 08 FP    KCU10', 'Turning Insert', 2,  1, 1),
        ('XDLT090408ER-D41   SP6519', '221938 09', 3,  1, 1),
        ('XDLT090408ER-D41   SP6519 Dub', '221938 09', 3,  1, 1),
        ('XDLT090412ER-D411   SP6519', 'Milling insert Inox', 3,  1, 1),
        ('Ø1.0 F2AH0100AWS30 KC625M', 'Ø1.0', 18,  1, 1),
        ('Ø1.0 F2AL0100AWS30 KC637M', 'Ø1.0', 18,  1, 1),
        ('Ø1.5 F2AL0150AWM30E100 KC637M', '2657422', 18,  1, 1),
        ('Ø10.0 UADE1000A4AL KCPM15', 'Ø10.0', 18,  1, 1),
        ('Ø10.0 UJBE1000A6AL   KCSM15', 'Radiefres', 18,  1, 1),
        ('Ø10.5 B976A10500 KC7315', 'HM Drill', 23,  1, 1),
        ('Ø12.5 B976A12500 KC7315', 'HM Drill', 23,  1, 1),
        ('Ø13.0 B977A13000', 'HM Drill', 23,  1, 1),
        ('Ø16.0 F4AS1600ADL38  KCPM15', 'Ø16.0', 18,  1, 1),
        ('Ø2.0 F3AH0200ADK45 KC633M', 'Ø2.0', 18,  1, 1),
        ('Ø3.0 UEBE0300A3A KC643M', 'Ø3.0', 18,  1, 1),
        ('Ø4.0 4CH0400MX031A KC633M', 'Ø4.0', 18,  1, 1),
        ('Ø4.3 B976A04300', 'HM Drill', 23,  1, 1),
        ('Ø4.366 B976A04366', 'HM Drill', 23,  1, 1),
        ('Ø5.0 F4AS0500ADL38 KC633M', 'Ø5.0', 18,  1, 1),
        ('Ø6.0 F4AS0600ADL38 KC633M', 'Ø6.0', 18,  1, 1),
        ('Ø6.0 UGDE0600A5BRB KC643M', 'Ø6.0', 18,  1, 1),
        ('Ø8.0 F4AS0800ADL38 KCPM15', 'Ø8.0', 18,  1, 1),
        ('Ø8.0 F4AW0800AWL38E160', 'Ø16.0', 18,  1, 1),
        ('Ø8.0 UADE0800A4AL KCPM15', 'Ø8.0', 18,  1, 1),
        ('Ø8.0 UEDE0800A4AH  KC643M', 'Ø8 Drill', 18,  1, 1),
        ('Ø8.7 B976A08700', 'HM Drill', 23,  1, 1),
        ('16ER10STACME   CP500', 'Threading insert Stub ACME', 6,  1, 1),
        ('16NR10STACME   CP500', 'Threading insert Stub ACME', 6,  1, 1),
        ('27ER6.0TR   CP500', 'Threading insert Trapets', 12,  1, 1),
        ('CCMT 06 02 08-F1    CP500', 'Turning Insert', 2,  1, 1),
        ('CDCB 04 T0 04    CP500', 'Turning Insert', 2,  1, 1),
        ('DCMT 07 02 04-F1    CP500', 'Turning Insert', 2,  1, 1),
        ('DCMT 07 02 08-F1    CP500', 'Turning Insert', 2,  1, 1),
        ('DCMT 11 T3 04-F1    TP1030', 'Turning Insert', 2,  1, 1),
        ('R335.15-02635913       F40M Dub1', 'Special grooving', 14,  1, 1),
        ('R335.15-02635913       F40M Dub2', 'Special grooving', 14,  1, 1),
        ('R335.15-02635913       F40M', 'Special grooving', 14,  1, 1),
        ('RCMT 08 03 M0-F1    CP500', 'Milling insert', 3,  1, 1),
        ('VBMT 11 02 08-F1    TP300', 'Turning Insert', 2,  1, 1),
        ('VBMT 16 04 08-F1    CP500', 'Turning Insert', 2,  1, 1),
        ('WNMG 08 04 08-M5    TP30', 'Turning Insert', 2,  1, 1),
        ('Ø15.5 SD205A', 'HM Drill', 23,  1, 1),
        ('Ø7.55 SD205A', 'HM Drill', 23,  1, 1),
        ('APMT133504 ER    HB7630', '215350_INOX', 3,  1, 1),
        ('APMT180508 TR    HB7520', 'Milling insert', 3,  1, 1),
        ('APMT180508 TR    HB7720', 'Milling insert Universal', 3,  1, 1),
        ('CNMG 12 04 08 SM    HPC710', 'Turning Insert', 2,  1, 1),
        ('CNMG 12 04 08 VM    HB7120', 'Turning Insert', 2,  1, 1),
        ('R=3.5 208020', 'Hjørnradiefres', 21,  1, 1),
        ('R=5.0 194220', 'Hjørnradiefres', 21,  1, 1),
        ('RDMW 12T3MOT    HB 7505', 'Milling insert', 3,  1, 1),
        ('RDMW 12T3MOT    HB 7505 Dub', 'Milling insert', 3,  1, 1),
        ('XDLT090408ER-D721', '029637', 3,  1, 1),
        ('XDLT090412ER-D411', '221930 09', 3,  1, 1),
        ('Ø1.5 HM RADIEFRES', 'G201630 1.5', 21,  1, 1),
        ('Ø1.5 HM-FRES TIALN', 'G201630 1.5', 18,  1, 1),
        ('Ø10.2 122404', 'HM Drill', 23,  1, 1),
        ('Ø10.3 122404', 'HM Drill', 23,  1, 1),
        ('Ø10.5 122659', 'HM Drill', 23,  1, 1),
        ('Ø11.0 122404', 'HM Drill', 23,  1, 1),
        ('Ø11.0 122630', 'HM Drill', 23,  1, 1),
        ('Ø11.8 122630', 'HM Drill', 23,  1, 1),
        ('Ø12.0 122250', 'VHM Drill', 23,  1, 1),
        ('Ø12.0 122380', '122380 12', 23,  1, 1),
        ('Ø12.0 G202243', 'G202243 12', 18,  1, 1),
        ('Ø14.0 122630', 'HM Drill', 23,  1, 1),
        ('Ø16.0 122630', 'HM Drill', 18,  1, 1),
        ('Ø16.0 G202243', 'G202243 12', 18,  1, 1),
        ('Ø18.0 123100', 'HM Drill', 23,  1, 1),
        ('Ø19.5X4 T-SPOR HM FRES', 'G208025 19.5x4', 21,  1, 1),
        ('Ø2 SLOT DRILL ALU', 'G191100', 18,  1, 1),
        ('Ø2.0 122150', '122150 2,0', 23,  1, 1),
        ('Ø2.0 122404', '122404 2,0', 23,  1, 1),
        ('Ø2.0 GARANT VHM-FRES', '206033-2X10', 18,  1, 1),
        ('Ø2.6 122404', '122404 2,6', 23,  1, 1),
        ('Ø22.0 194302', '194302 22', 21,  1, 1),
        ('Ø25.5X5 T-SPOR HM FRES', '208025 25,5X5', 21,  1, 1),
        ('Ø26.0 194302', '194302 26', 21,  1, 1),
        ('Ø3.0 201270', '201270 3', 18,  1, 1),
        ('Ø3.7 122150', '122150 3,7', 23,  1, 1),
        ('Ø3.7 122404', '122404 3,7', 23,  1, 1),
        ('Ø4.0 122404', '122404 4', 23,  1, 1),
        ('Ø4.6 122659', '122659 4,6', 23,  1, 1),
        ('Ø5.55 122630', '122630 5,55', 23,  1, 1),
        ('Ø5.55 122659', '122659 5,55', 23,  1, 1),
        ('Ø6.0 122430', '122430 6', 23,  1, 1),
        ('Ø6.0 192860', '192860 6', 18,  1, 1),
        ('Ø6.5 122540', '122540 6,5', 23,  1, 1),
        ('Ø6.5 123106', '123106 6,5', 23,  1, 1),
        ('Ø6.6 122404', '122404 6,6', 23,  1, 1),
        ('Ø8.0/1.0 HOLEX HM-FRES', 'G206353 8/1,0', 18,  1, 1),
        ('Ø8.5 122380', '122380 8,5', 23,  1, 1),
        ('BDMT170440ER-JT', 'Milling insert Stainless', 3,  1, 1),
        ('CNMG 12 04 08 MS    PR1125', 'Turning Insert', 2,  1, 1),
        ('Ø5.0 86511 HARTNER', 'HM Drill', 23,  1, 1),
        ('Ø5.0 89410 HARTNER', 'HM Drill', 23,  1, 1),
        ('Ø10.0 IZAR 6644 NRF', 'SKRUBBFRES', 18,  1, 1),
        ('Ø12.0 IZAR 4422 N', 'RADIEFRES', 21,  1, 1),
        ('Ø12.0 PMX IZAR 6644 NRF', 'SKRUBBFRES', 18,  1, 1),
        ('Ø6.0 IZAR 6644 NR-F', 'RADIEFRES', 21,  1, 1),
        ('Ø8.0 PMX IZAR 6644 NRF', 'SKRUBBFRES', 18,  1, 1),
        ('Ø10.0 C305', 'PRIMAX SLOT DRILL', 23,  1, 1),
        ('Ø11.2 R002', 'HM Drill', 23,  1, 1),
        ('Ø13.0 A110', 'High Performance HSCo Deep', 23,  1, 1),
        ('Ø14.0 R453', 'HM Drill', 23,  1, 1),
        ('Ø16.0 C305', 'PRIMAX SLOT DRILL', 23,  1, 1),
        ('Ø5.0 C503', 'RADIEFRES', 21,  1, 1),
        ('Ø6.0 C492', 'SKRUBBFRES', 18,  1, 1),
        ('Ø6.0 S511', 'Radiefres', 21,  1, 1),
        ('Ø8.0 C492', 'RADIEFRES', 21,  1, 1),
        ('Ø8.1 R557', 'HM Drill', 23,  1, 1),
        ('Ø8.2 R571', 'HM Drill', 23,  1, 1),
        ('12E 1.0ISO T10C', 'Quad Cut', 15,  1, 1),
        ('12E 1.75ISO T10C', 'Quad Cut', 15,  1, 1),
        ('12E 2.5ISO T10R', 'Quad Cut', 15,  1, 1),
        ('20ER3ACME   CP500', 'Threading insert ACME', 5,  1, 1),
        ('CCGT 06 02 04-1L    KX20', 'Turning Insert', 2,  1, 1),
        ('CNMG 12 04 08-MA    MC7025', 'Turning Insert', 2,  1, 1),
        ('CNMG 12 04 08-MA    UE6110', 'Turning Insert', 2,  1, 1),
        ('CNMG 12 04 12-MA    MC7025', 'Turning Insert', 2,  1, 1),
        ('D4XR1.5 10G101', 'Hjørnradiefres', 21,  1, 1),
        ('D6XR1.5 10G115', 'Hjørnradiefres', 21,  1, 1),
        ('DCGT 07 02 04-1L    KX20', 'Turning Insert', 2,  1, 1),
        ('DCGT 11 T3 08-1L    KX20', 'Turning Insert', 2,  1, 1),
        ('DCGT 11T304    K15', 'Turning Insert', 2,  1, 1),
        ('DCGT 11T308    K15', 'Turning Insert', 2,  1, 1),
        ('DNMG 15 06 08-MA    MC7025', 'Turning Insert', 2,  1, 1),
        ('DNMG 15 06 08-MA    UE6110', 'Turning Insert', 2,  1, 1),
        ('DNMG 15 06 12-MA    MC7025', 'Turning Insert', 2,  1, 1),
        ('DNMG 15 06 12-MA    UE6110', 'Turning Insert', 2,  1, 1),
        ('R=5.0 VHM 6415', 'Hjørnradiefres', 21,  1, 1),
        ('R41E3.50ISOTM   VTX', 'Threading insert', 7,  1, 1),
        ('SPMG 060204 DG TT8020', 'borrskjer', 13,  1, 1),
        ('SPMG 07T308 DG TT8020', 'Drilling insert', 13,  1, 1),
        ('SPMG 090408 DG TT8020', 'borrskjer', 13,  1, 1),
        ('SPMG 110408 DG TT8020', 'borrskjer', 13,  1, 1),
        ('SPMG 140512 DG TT8020', 'borrskjer', 13,  1, 1),
        ('TCGT 11 02 04    K15', 'Milling insert', 3,  1, 1),
        ('TCMT 16T304-PM5    8535', 'Milling insert', 3,  1, 1),
        ('TNMG160404    T5020', 'Milling insert', 3,  1, 1),
        ('WCMT 050308-C20  NCM325', 'Drilling insert', 13,  1, 1),
        ('Ø10.0 MPS1000-L12C', 'HM-Drill 12xDia', 23,  1, 1),
        ('Ø11.0 A6589', 'HM Drill', 23,  1, 1),
        ('Ø11.0 MS1100-SLA', 'Solid Carbide Drill', 23,  1, 1),
        ('Ø12.0 MAX-MILL 1011D12 R4 HMX', 'HJØRNRADIEFRES', 21,  1, 1),
        ('Ø12.0 MS1200-SLA', 'Solid Carbide Drill', 23,  1, 1),
        ('Ø13.0 SILMAX D.13.0X77X124 G14', 'HM Drill', 23,  1, 1),
        ('Ø14.5 MZS1450S-DIN-C', 'Solid Carbide Drill', 18,  1, 1),
        ('Ø19.0 R9.5 HM4/29', 'Radiefres', 21,  1, 1),
        ('Ø2.4 MZS0240LB VP15TF', 'Solid Carbide Drill', 23,  1, 1),
        ('Ø3.0 3X7X50', 'Radiefres', 21,  1, 1),
        ('Ø4.0 4X11X55', 'Radiefres Ø4', 21,  1, 1),
        ('Ø4.0 MSL0400 L20G', 'Solid Carbide Drill', 23,  1, 1),
        ('Ø4.4 MPS0440L-DIN-C', 'Solid Carbide Drill', 23,  1, 1),
        ('Ø4.5 MZS0450LB VP15TF', 'Solid Carbide Drill', 23,  1, 1),
        ('Ø5.0 MAX-MILL 923 5X8X80 R0.1', 'HM LANG FRES', 18,  1, 1),
        ('Ø6.0 VIFREE 2013 6X13X57', 'HM FRES', 18,  1, 1),
        ('Ø8.0 MPS0800-L8C', 'Solid Carbide Drill', 23,  1, 1),
        ('266RG-16AC01F080E   1135', 'Threading insert ACME', 5,  1, 1),
        ('266RG-16MM01A100M   1125', 'Threading insert Metric', 7,  1, 1),
        ('266RG-16MM01A150M   1125', 'Threading insert Metric', 7,  1, 1),
        ('266RG-16MM01A200M   1125', 'Threading insert Metric', 7,  1, 1),
        ('266RG-16MM01A250M   1125', 'Threading insert Metric', 7,  1, 1),
        ('266RG-16MM01A300M   1125', 'Threading insert Metric', 7,  1, 1),
        ('266RG-16MM03A100M   1125', 'Threading insert Metric', 7,  1, 1),
        ('266RG-16NF01A115E   1125', 'Threading insert NPT', 10,  1, 1),
        ('266RG-16NT01A080M   1125', 'Threading insert NPT', 10,  1, 1),
        ('266RG-16NT01A140M   1135', 'Threading insert NPT', 10,  1, 1),
        ('266RG-16NT01A180M   1125', 'Threading insert NPT', 10,  1, 1),
        ('266RG-16SA01F100E   1135', 'Threading insert Stub ACME', 6,  1, 1),
        ('266RG-16SA01F120E   1135', 'Threading insert Stub ACME', 6,  1, 1),
        ('266RG-16UN01A080M   1135', 'Threading insert', 8,  1, 1),
        ('266RG-16UN01A100M   1125', 'Threading insert', 8,  1, 1),
        ('266RG-16UN01A120M   1125', 'Threading insert', 8,  1, 1),
        ('266RG-16UN01A160M   1125', 'Threading insert', 8,  1, 1),
        ('266RG-16VM01A001M   1125', 'Threading insert Pipe', 11,  1, 1),
        ('266RG-16WH01A110M   1125', 'Threading insert Pipe', 9,  1, 1),
        ('266RG-16WH01A190M   1125', 'Threading insert Pipe', 9,  1, 1),
        ('266RG-16WH01A280M   1125', 'Threading insert Pipe', 9,  1, 1),
        ('266RG-22AC01F060E   1020', 'Threading insert ACME', 5,  1, 1),
        ('266RG-22MM01A350M   1020', 'Threading insert Metric', 7,  1, 1),
        ('266RG-22MM01A400M   1020', 'Threading insert Metric', 7,  1, 1),
        ('266RG-22MM01A450M   1020', 'Threading insert Metric', 7,  1, 1),
        ('266RG-22MM01A500M   1020', 'Threading insert Metric', 7,  1, 1),
        ('266RG-22MM01A550M   1020', 'Threading insert Metric', 7,  1, 1),
        ('266RG-22MM01A600M   1020', 'Threading insert Metric', 7,  1, 1),
        ('266RG-22MM01A600M   1125', 'Threading insert Metric', 7,  1, 1),
        ('266RG-22TR01F400E   1020', 'Threading insert Trapets', 12,  1, 1),
        ('266RG-22UN01A060M   1020', 'Threading insert', 8,  1, 1),
        ('266RL-16AC01F080E   1135', 'Threading insert ACME', 5,  1, 1),
        ('266RL-16MM01A150M   1125', 'Threading insert Metric', 7,  1, 1),
        ('266RL-16MM01A200M   1125', 'Threading insert Metric', 7,  1, 1),
        ('266RL-16MM01A300M   1125', 'Threading insert Metric', 7,  1, 1),
        ('266RL-16NF01A140E   1125', 'Threading insert NPT', 10,  1, 1),
        ('266RL-16SA01F120E   1135', 'Threading insert Stub ACME', 6,  1, 1),
        ('266RL-16UN01A080M   1135', 'Threading insert', 8,  1, 1),
        ('266RL-16UN01A100M   1125', 'Threading insert', 8,  1, 1),
        ('266RL-22AC01F060E   1020', 'Threading insert ACME', 5,  1, 1),
        ('266RL-22MM01A350M   1020 Dub', 'Threading insert Metric', 7,  1, 1),
        ('266RL-22MM01A350M   1020', 'Threading insert Metric', 7,  1, 1),
        ('266RL-22MM01A400M   1020 Dub', 'Threading insert Metric', 7,  1, 1),
        ('266RL-22MM01A400M   1020', 'Threading insert Metric', 7,  1, 1),
        ('266RL-22MM01A450M   1020 Dub', 'Threading insert Metric', 7,  1, 1),
        ('266RL-22MM01A450M   1020', 'Threading insert Metric', 7,  1, 1),
        ('266RL-22MM01A600M   1125 Dub', 'Threading insert Metric', 7,  1, 1),
        ('266RL-22MM01A600M   1125', 'Threading insert Metric', 7,  1, 1),
        ('266RL-22SA01F050E   1020 Dub', 'Threading insert Stub ACME', 6,  1, 1),
        ('266RL-22SA01F050E   1020', 'Threading insert Stub ACME', 6,  1, 1),
        ('266RL-22TR01F400E   1020 Dub', 'Threading insert Trapets', 12,  1, 1),
        ('266RL-22TR01F400E   1020', 'Threading insert Trapets', 12,  1, 1),
        ('266RL-22UN01A070M   1020', 'Threading insert', 8,  1, 1),
        ('490R-08T308M-PL     1030', 'Milling insert', 3,  1, 1),
        ('880-01 02 03H-C-LM  1044', 'Drilling insert', 13,  1, 1),
        ('880-01 02 W04H-P-LM 4044', 'Drilling insert', 13,  1, 1),
        ('880-02 02 04H-C-GM  1044', 'Drilling insert', 13,  1, 1),
        ('880-02 02 W04H-P-GM 4024', 'Drilling insert', 13,  1, 1),
        ('880-03 03 05H-C-GM  1044', 'Drilling insert', 13,  1, 1),
        ('880-03 03 W05H-P-GM 4044', 'Drilling insert', 13,  1, 1),
        ('880-04 03 05H-C-GM  1044', 'Drilling insert', 13,  1, 1),
        ('880-04 03 05H-C-LM  1044', 'Drilling insert', 13,  1, 1),
        ('880-04 03 05H-C-LM  H13A', 'Drilling insert', 13,  1, 1),
        ('880-04 03 W05H-P-GM 4044', 'Drilling insert', 13,  1, 1),
        ('880-04 03 W07H-P-GT 4044', 'Drilling insert', 13,  1, 1),
        ('880-05 03 05H-C-GM 1044', 'Drilling insert', 13,  1, 1),
        ('880-05 03 05H-C-LM 1144', 'Drilling insert', 13,  1, 1),
        ('880-05 03 W05H-P-GM 4044', 'Drilling insert', 13,  1, 1),
        ('880-06 04 06H-C-GM 1044', 'Drilling insert', 13,  1, 1),
        ('880-06 04 06H-C-LM H13A', 'Drilling insert', 13,  1, 1),
        ('880-06 04 08H-P-LM H13A', 'Drilling insert', 13,  1, 1),
        ('880-06 04 W06H-P-GM 4024', 'Drilling insert', 13,  1, 1),
        ('880-07 04 06H-C-GM  1044', 'Drilling insert', 13,  1, 1),
        ('880-07 04 W06H-P-GM 4044', 'Drilling insert', 13,  1, 1),
        ('880-08 05 08H-C-GM  1044', 'Drilling insert', 13,  1, 1),
        ('880-08 05 08H-C-GR  1044', 'Drilling insert', 13,  1, 1),
        ('880-08 05 W08H-P-GM 4024', 'Drilling insert', 13,  1, 1),
        ('880-08 05 W08H-P-GM 4044', 'Drilling insert', 13,  1, 1),
        ('CCMT 06 02 04-MM    1025', 'Turning Insert', 2,  1, 1),
        ('CCMT 06 02 08-MM    1025', 'Turning Insert', 2,  1, 1),
        ('CNMG 12 04 04-WF    4015', 'Turning Insert', 2,  1, 1),
        ('CNMG 12 04 08-MM    2025', 'Turning Insert', 2,  1, 1),
        ('CNMG 12 04 08-SMR    2025', 'Turning Insert', 2,  1, 1),
        ('CNMG 16 06 12-MM    2025', 'Turning Insert', 2,  1, 1),
        ('DCMT 07 02 04-MM    2025', 'Turning Insert', 2,  1, 1),
        ('DCMT 07 02 04-MM    2035', 'Turning Insert', 2,  1, 1),
        ('DCMT 11 T3 02-MF    1025', 'Turning Insert', 2,  1, 1),
        ('DCMT 11 T3 04-MM    2025', 'Turning Insert', 2,  1, 1),
        ('DCMT 11 T3 04-MM    2035', 'Turning Insert', 2,  1, 1),
        ('DCMT 11 T3 04-UF    5015', 'Turning Insert', 2,  1, 1),
        ('DCMT 11 T3 08-MM    2025', 'Turning Insert', 2,  1, 1),
        ('DCMT 11 T3 08-MM    2035', 'Turning Insert', 2,  1, 1),
        ('DNMG 15 06 08-MM    2035', 'Turning Insert', 2,  1, 1),
        ('DNMG 15 06 08-PM    4225', 'Turning Insert', 2,  1, 1),
        ('DNMG 15 06 12-PM    4225', 'Turning Insert', 2,  1, 1),
        ('DNMG 15 06 12-PM    4325', 'Turning Insert', 2,  1, 1),
        ('DNMP 15 04 08    432', 'Turning Insert', 2,  1, 1),
        ('L166.0L-22AC01F040   1020', 'Threading insert ACME', 5,  1, 1),
        ('LCMX 02 02 04C-53    1020', 'Drilling insert', 13,  1, 1),
        ('LCMX 02 02 04P-53    1120', 'Drilling insert', 13,  1, 1),
        ('LCMX 03 03 08-53    1020', 'Drilling insert', 13,  1, 1),
        ('R166.0G-16AC01F080   1020', 'Threading insert ACME', 5,  1, 1),
        ('R166.0G-16AC01F100   1020', 'Threading insert ACME', 5,  1, 1),
        ('R166.0G-16AC01F120   1020', 'Threading insert ACME', 5,  1, 1),
        ('R166.0G-16MM01-050   1020', 'Threading insert Metric', 7,  1, 1),
        ('R166.0G-16MM01-125   1020', 'Threading insert Metric', 7,  1, 1),
        ('R166.0G-16MM01-175   1020', 'Threading insert Metric', 7,  1, 1),
        ('R166.0G-16MM01F080   1020', 'Threading insert Metric', 7,  1, 1),
        ('R166.0G-16PT01-140   1020', 'Threading insert', 10,  1, 1),
        ('R166.0G-16SA01-160   1020', 'Threading insert Stub ACME', 6,  1, 1),
        ('R166.0G-16SA01F080   1020', 'Threading insert Stub ACME', 6,  1, 1),
        ('R166.0G-16TR01F300   1020', 'Threading insert Trapets', 12,  1, 1),
        ('R166.0G-16UN01-080   1020', 'Threading insert', 8,  1, 1),
        ('R166.0G-16UN01-100   1020', 'Threading insert', 8,  1, 1),
        ('R166.0G-16UN01-180   1020', 'Threading insert', 8,  1, 1),
        ('R166.0G-16UN01-200   1020', 'Threading insert', 8,  1, 1),
        ('R166.0G-16UN01-240   1020', 'Threading insert', 8,  1, 1),
        ('R166.0G-16VM01-001   1020', 'Threading insert Pipe', 11,  1, 1),
        ('R166.0G-16VM01-002   1020', 'Threading insert Pipe', 11,  1, 1),
        ('R166.0G-16WH01-080   1020', 'Threading insert Pipe', 9,  1, 1),
        ('R166.0G-16WH01-180   1020', 'Threading insert Pipe', 9,  1, 1),
        ('R166.0G-16WH01-190   1020', 'Threading insert Pipe', 9,  1, 1),
        ('R166.0G-22AC01F040   1020', 'Threading insert ACME', 5,  1, 1),
        ('R166.0G-22AC01F050   1020', 'Threading insert ACME', 5,  1, 1),
        ('R166.0G-22MM01-500   1020', 'Threading insert Metric', 7,  1, 1),
        ('R166.0G-22MM01-550   1020', 'Threading insert Metric', 7,  1, 1),
        ('R166.0G-22MM01-600   1020', 'Threading insert Metric', 7,  1, 1),
        ('R166.0G-22SA01F040   1020', 'Threading insert Stub ACME', 6,  1, 1),
        ('R166.0G-22SA01F050   1020', 'Threading insert Stub ACME', 6,  1, 1),
        ('R166.0G-22WH01-070   1020', 'Threading insert Pipe', 9,  1, 1),
        ('R166.0L-11MM01-150   1020', 'Threading insert Metric', 7,  1, 1),
        ('R166.0L-11MM01-200   1020', 'Threading insert Metric', 7,  1, 1),
        ('R166.0L-16AC01F100   1020', 'Threading insert ACME', 5,  1, 1),
        ('R166.0L-16AC01F120   1020', 'Threading insert ACME', 5,  1, 1),
        ('R166.0L-16MM01-075   1020', 'Threading insert Metric', 7,  1, 1),
        ('R166.0L-16MM01-100   1020', 'Threading insert Metric', 7,  1, 1),
        ('R166.0L-16MM01-300   1020', 'Threading insert Metric', 7,  1, 1),
        ('R166.0L-16NF01-140   1020', 'Threading insert NPT', 10,  1, 1),
        ('R166.0L-16NT01-080   1020', 'Threading insert NPT', 10,  1, 1),
        ('R166.0L-16NT01-115   1020', 'Threading insert NPT', 10,  1, 1),
        ('R166.0L-16PT01-140   1020', 'Threading insert', 10,  1, 1),
        ('R166.0L-16SA01F080   1020', 'Threading insert Stub ACME', 6,  1, 1),
        ('R166.0L-16SA01F100   1020', 'Threading insert Stub ACME', 6,  1, 1),
        ('R166.0L-16TR01F300   1020', 'Threading insert Trapets', 12,  1, 1),
        ('R166.0L-16UN01-080   1020', 'Threading insert', 8,  1, 1),
        ('R166.0L-16VM01-001   1020', 'Threading insert Pipe', 11,  1, 1),
        ('R166.0L-22AC01F050   1020 Dub', 'Threading insert ACME', 5,  1, 1),
        ('R166.0L-22AC01F050   1020', 'Threading insert ACME', 5,  1, 1),
        ('R166.0L-22AC01F060   1020', 'Threading insert ACME', 5,  1, 1),
        ('R166.0L-22MM01-350   1020 Dub', 'Threading insert Metric', 7,  1, 1),
        ('R166.0L-22MM01-350   1020', 'Threading insert Metric', 7,  1, 1),
        ('R166.0L-22MM01-500   1020 Dub', 'Threading insert Metric', 7,  1, 1),
        ('R166.0L-22MM01-500   1020', 'Threading insert Metric', 7,  1, 1),
        ('R166.0L-22MM01-550   1020 Dub', 'Threading insert Metric', 7,  1, 1),
        ('R166.0L-22MM01-550   1020', 'Threading insert Metric', 7,  1, 1),
        ('R166.0L-22SA01-060   1020 Dub', 'Threading insert Stub ACME', 6,  1, 1),
        ('R166.0L-22SA01-060   1020', 'Threading insert Stub ACME', 6,  1, 1),
        ('R166.0L-22SA01F040   1020 Dub', 'Threading insert Stub ACME', 6,  1, 1),
        ('R166.0L-22SA01F040   1020', 'Threading insert Stub ACME', 6,  1, 1),
        ('R166.0L-22V381-0403   1020 M20', 'Threading insert Stub ACME', 6,  1, 1),
        ('R210-09 04 14E-PM   4240', 'Milling insert', 3,  1, 1),
        ('R245-12 T3 K-MM     2040', 'Milling insert', 3,  1, 1),
        ('R245-12 T3 M-KH     3040', 'Milling insert', 3,  1, 1),
        ('R245-12 T3 M-PM     1030', 'Milling insert', 3,  1, 1),
        ('R390-11 T3 08M-MM   2030', 'Milling insert', 3,  1, 1),
        ('R390-11 T3 31E-KM   H13A', 'Milling insert', 3,  1, 1),
        ('RCHT 12 04 M0-PL    1030', 'Milling insert', 3,  1, 1),
        ('RCKT 12 04 M0-PM    4020', 'Milling insert', 3,  1, 1),
        ('RCMT 06 02 M0    2025', 'Milling insert', 3,  1, 1),
        ('RCMT 08 03 M0    4025', 'Milling insert', 3,  1, 1),
        ('SNMG 12 04 08   4025', 'Milling insert', 3,  1, 1),
        ('SNMG 12 04 16-KM   3005', 'Milling insert', 3,  1, 1),
        ('SPMT 12 04 08-WH   SM30', 'Milling insert', 3,  1, 1),
        ('TPMT 09 02 08-MM    2025', 'Turning Insert', 2,  1, 1),
        ('VBMT 11 03 04-MF    2025', 'Turning Insert', 2,  1, 1),
        ('VBMT 16 04 02-MF    1125', 'Turning Insert', 2,  1, 1),
        ('VBMT 16 04 04-MM    1125', 'Turning Insert', 2,  1, 1),
        ('VBMT 16 04 04-PM    4215', 'Turning Insert', 2,  1, 1),
        ('VBMT 16 04 08-MM    1125', 'Turning Insert', 2,  1, 1),
        ('VBMT 16 04 08-SMC    1115', 'Turning Insert', 2,  1, 1),
        ('VBMT 16 04 08-UM    H13A', 'Turning Insert', 2,  1, 1),
        ('VCMT 11 03 04-MM    2025', 'Turning Insert', 2,  1, 1),
        ('VNMG 16 04 04-MF    5015', 'Turning Insert', 2,  1, 1),
        ('WCMX 05 03 08 R-53  1020', 'Drilling insert', 13,  1, 1),
        ('WCMX 06 T3 08 R-53  1020', 'Drilling insert', 13,  1, 1),
        ('WCMX 08 04 12 R-53  1020', 'Drilling insert', 13,  1, 1),
        ('WNMG 08 04 08-QM    4035', 'Turning Insert', 2,  1, 1),
        ('WNMG 08 04 08-QM    4225', 'Turning Insert', 2,  1, 1),
        ('WNMG 08 04 08-QM    H13A', 'Turning Insert', 2,  1, 1),
        ('ADKR 1505PDR-HM    IC328', 'Milling insert', 3,  1, 1),
        ('DNMG 15 06 08-GN   IC9150', 'Turning Insert', 2,  1, 1),
        ('DNMG 15 06 08-M3M    IC6025', 'Turning Insert', 2,  1, 1),
        ('HM390 TPKT 1003PDR IC830', 'Milling insert', 3,  1, 1),
        ('HM90 ADKT 1505PDR  IC830', 'Milling insert', 3,  1, 1),
        ('LNET 083004-TN-N   IC928', 'Milling insert', 3,  1, 1),
        ('LNET 083504-TN-N   IC928', 'Milling insert', 3,  1, 1),
        ('DNMG 15 06 08EN-TM    CTCP125', 'Turning Insert', 2,  1, 1),
        ('XCNT 060204EN   CTP2440', 'Drilling insert', 13,  1, 1),
        ('XCNT 080304EN   CTP2440', 'Drilling insert', 13,  1, 1),
        ('XCNT 10T304EN   CTP2440', 'Drilling insert', 13,  1, 1),
        ('Ø10.3 SPC1030-0309K', 'HM Drill', 23,  1, 1),
        ('Ø5.0 W0177050240', 'HM Drill', 23,  1, 1),
        ('Ø6.8 W0177068240', 'HM Drill', 23,  1, 1),
        ('Ø8.5 W0177085240', 'HM Drill', 23,  1, 1); ");

	}
}
