
<div class="pure-u-1-2 pure-u-md-1-<?php echo $perrow; ?>">
<div class="margin-box">
<figure class="cap-left">
<center>
<?php
			if($permalink=="0")
			{
			echo '<img src="'.$image.'" class="pure-img" ><figcaption> '.$thetitle.' </figcaption> ';
			}
		else
		{
			if($popup=="on")
			{
			
			echo '<a href="'.$preview_large.'" title="'.$thetitle.'" class="'.$preview_type.'" border=0><img src="'.$image.'" class="pure-img"><figcaption> '.$thetitle.' </figcaption> </a>';
			}
			else
			{
			echo '<a href="'.$permalink.'" border=0><img src="'.$image.'" class="pure-img"><figcaption> '.$thetitle.' </figcaption> </a>';
			}
		}

			?>
			<?php echo upg_show_icon_grid(); ?>
			</center>
			</figure>
			</div>
  
  </div>