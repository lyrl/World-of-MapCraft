<?
	#
	# take world tiles and build a chunk ready for assembling along with wmo chunks
	#

	include('../build/config.php');


	#create_world('inst_vc', 'deadminesinstance', 33, 33, 31, 32, 32, 160, 192, 256);
	#create_world('inst_sfk', 'shadowfang', 27, 28, 32, 32, 150, 30, 150, 130);
	#create_world('inst_cos', 'stratholmecot', 28,31, 28,29, 0,37, 1024,512-27);
	#create_world('inst_ramps', 'hellfirerampart', 28,31, 33,35, 0,0, 512, 768);
	#create_world('inst_mgt', 'sunwell5manfix', 31,32, 31,32, 58,25, 409,333);
	#create_world('raid_sunwell', 'sunwellplateau', 28,32, 26,31, 10,10, (256*5)-20, (256*6)-20);
	#create_world('inst_dtk', 'draktheronkeep', 31,34, 30,34, 133+230,430, 640-230,460);
	#create_world('raid_bt', 'blacktemple', 29,32, 28,32, 195,478, 613,428);
	#create_world('raid_fl', 'firelands1', 30,33, 29,33, 0,0, 1024,1280, 'noliquid_');
	#create_world('raid_ulduar_1', 'ulduarraid', 30,33, 29,34, 225,237, 565,1226);
	#create_world('raid_ulduar_2', 'ulduarraid', 31,32, 27,28, 129,42, 295,220);
	#create_world('inst_uk', 'valgarde70', 31,32, 31,32, 90,20, 512,310);

	#create_world('raid_ds_hagara', 'deathwingback', 6,6, 6,6, 0,0, 256,256);
	#create_world('raid_ds_warmaster', 'deathwingback', 53,55, 5,7, 196-50,219-50, 496+100,497+100);
	#create_world('raid_ds_main', 'deathwingback', 35,37, 34,37, 0,0, 768,1024);
	#create_world('raid_ds_deathwing', 'deathwingback', 8,11, 53,55, 0,0, 768,768);
	#create_world('raid_ds_spine', 'deathwingback', 57,57, 57,58, 0,0, 256,512);

	#create_world('inst_hoo', 'uldum', 32,33, 32,33, 57,33, 512,460);
	create_world('inst_tot', 'abyssalmaw_interior', 30,30, 32,32, 0,0, 256,196);

	function create_world($out_name, $map_name, $x1, $x2, $y1, $y2, $crop_x, $crop_y, $crop_w, $crop_h, $prefix=''){

		echo "$out_name: ";

		global $pngs, $flats;

		$temp = "$flats/temp.png";
		$dst = "$flats/{$out_name}.png";
		$w = 256 * (1 + $x2 - $x1);
		$h = 256 * (1 + $y2 - $y1);

		echo shell_exec("convert xc:blue -geometry !{$w}x{$h} $temp");

		for ($x=$x1; $x<=$x2; $x++){
		for ($y=$y1; $y<=$y2; $y++){

			$xp = ($x-$x1) * 256;
			$yp = ($y-$y1) * 256;

			$xx = sprintf('%02d', $x);
			$yy = sprintf('%02d', $y);

			$src = "$pngs/{$map_name}/{$prefix}map{$xx}_{$yy}.png";

			echo shell_exec("composite $src -geometry +{$xp}+{$yp} $temp $temp");
			echo '.';

			#echo "$dst $src $xp,$yp\n";
		}
		}

		echo shell_exec("convert $temp -crop {$crop_w}x{$crop_h}+{$crop_x}+{$crop_y}! $dst");

		echo " done\n";
	}
