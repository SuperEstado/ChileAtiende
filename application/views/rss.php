<?php
	//Genera el contenido del rss
  header("Content-Type: application/xml; charset=UTF-8");

  echo '<?xml version="1.0" encoding="UTF-8"?>';
  echo '<rss version="2.0">';
  echo '<channel>';
  echo '<title>'.$titulo.'</title>';
  echo '<link>'.$link.'</link>';
  echo '<description>'.$descripcion.'</description>';

  foreach ($items as $item){
      echo '<item>';
      echo '<title>' . $item->titulo . '</title>';
      echo '<link>' . $item->link . '</link>';
      echo '<description><![CDATA[' . $item->descripcion . ']]></description>';
      echo '</item>';
	}

  echo '</channel>';
  echo '</rss>';
?>