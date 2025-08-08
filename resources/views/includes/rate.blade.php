<?php 
				$num = floor($rate);
				for($i= 0; $i< $num; $i++){
					echo '<i class="fas fa-star" style="color: #FFD43B;"></i>';
				}
				$decimal = $rate - $num;
				if ($decimal < 0.33){
					echo '<i class="far fa-star" style="color: #FFD43B;"></i>';
				}
				else if ($decimal < 0.67){
					echo '<i class="far fa-star-half-stroke" style="color: #FFD43B;"></i>';
				}
				else{
					echo '<i class="fas fa-star" style="color: #FFD43B;"></i>';
				}
				for ($i= $num; $i< 4 ; $i++){
					echo '<i class="far fa-star" style="color: #FFD43B;"></i>';
					
				}
                echo floor($rate*100)/100;