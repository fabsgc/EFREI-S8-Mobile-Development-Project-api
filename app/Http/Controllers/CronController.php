<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Support\Facades\DB;

class CronController extends Controller {
    /**
     * @return \Illuminate\Http\Response
     * @param int
     */
    public function updateData() {
        $departments = Department::all();
        DB::table('risks')->truncate();

        foreach ($departments as $department) {
            $img = imagecreatefromgif("http://internationalragweedsociety.org/vigilance/d%20" . $department->number . ".gif");
            $i = 0;
            $x = 115;
            $y = 47;

            while ($i != 19) {
                $rgb = imagecolorat($img, $x, $y);
                $colors = imagecolorsforindex($img, $rgb);

                if ($colors['red'] == 255 && $colors['green'] == 255 && $colors['blue'] == 255) {
                    $pollens[$i]["color"] = "brown";
                    $pollens[$i]["risk"] = 0;
                }
                elseif ($colors['red'] == 0 && $colors['green'] == 255 && $colors['blue'] == 0) {
                    $pollens[$i]["color"] = "rgb(0,255,0)";
                    $pollens[$i]["risk"] = 1;
                }
                elseif ($colors['red'] == 0 && $colors['green'] == 176 && $colors['blue'] == 80) {
                    $pollens[$i]["color"] = "rgb(0,176,80)";
                    $pollens[$i]["risk"] = 2;
                }
                elseif ($colors['red'] == 255 && $colors['green'] == 255 && $colors['blue'] == 0) {
                    $pollens[$i]["color"] = "rgb(255,255,0)";
                    $pollens[$i]["risk"] = 3;
                }
                elseif ($colors['red'] == 247 && $colors['green'] == 150 && $colors['blue'] == 70) {
                    $pollens[$i]["color"] = "rgb(247,150,70)";
                    $pollens[$i]["risk"] = 4;
                }
                else {
                    $pollens[$i]["color"] = "red";
                    $pollens[$i]["risk"] = 5;
                }

                DB::table('risks')->insert(
                    [
                        'risk' => $pollens[$i]["risk"],
                        'department_id' => $department->id,
                        'tree_id' => $i+1
                    ]
                );

                $y = $y + 20;
                $i++;
            }
        }
    }
}
