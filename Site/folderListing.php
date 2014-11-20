<?php
	include 'vars.php';

	function trimPaths($str)
	{
		$steps = explode('/', $str);
		//$str == "/home/qreon/music/Radiohead/../"
		//$steps == array('', 'home', 'qreon', 'music', 'Radiohead', '..', '')

		reset($steps);
		while(next($steps) !== false)
		{
			if(current($steps) == '..')
			{
				prev($steps);
				//On retourne à l'étape précédente
				array_splice($steps, key($steps), 2);
				//On vire les deux cases à l'endroit actuel
				next($steps);
				//On reavance pour annuler l'effet du prev()
			}
		}
		end($steps);
		unset($steps[key($steps)]);

		$res = '';
		foreach ($steps as $key => $value) {
			$res .= $value . '/';
		}

		return $res;
	}

	//Renvoie une chaîne formatée contenant les différents éléments du dossier courant
	function getFolderStructure($str)
	{
		global $musicDir;
		$str = trimPaths($str);  //On 'simplifie' le chemin spécifié (élimination des '/../', etc.)
		$t = scandir($str);     //On récupère la structure du dossier passé en paramètre
		$res = "";
		$exclude = array('.');  //Un tableau contient les valeurs à ne pas afficher
		if($str == $musicDir)   //Si on se trouve dans le dossier racine
		{
			$exclude[] = '..';  //On n'affiche pas ..
		}

		foreach ($t as $key => $value) {                                            //Pour chacune des valeurs de $t
			if(!in_array($value, $exclude))                                         //Si l'élément actuel n'est pas exclus
			{
				$icon ='';                                                          //On initialise des trucs
				$ajax = '';

				if($value == '..')                                                  //Si on a '..'
				{
					$value = 'Dossier parent';                                      //On affiche 'Dossier parent' et pas ..
					$icon = '<i class="fa fa-folder-o"></i>   ';                    //On rajoute une icône de dossier
					$ajax = " onclick=\"reloadFolderStructure('" . $str . "../')\"";//On rajoute un attribut 'onClick' qui exécutera du AJAX
					//Pourquoi $str . '../' fonctionne :
					//La première fois que getFolderStructure est appelée, $str == '/home/qreon/music/'
					//Aller dans un sous dossier appellera de nouveau getFolderStructure, avec $str == '/home/qreon/music/Radiohead/' par exemple
					//Remonter au dossier parent <=> $str . '../' <=> '/home/qreon/music/Radiohead/../'
					//On simplifie ensuite vers '/home/qreon/music/' grâce à la fonction trimPaths
				}
				else
				{
					if(preg_match('/.mp3$/', $value))
					{
						$icon = '<i class="fa fa-music"></i> ';
					}
					if(is_dir($str.$value))
					{
						$icon = '<i class="fa fa-folder-o"></i>   ';
						$ajax = " onclick=\"reloadFolderStructure('". $str . $value . "/" ."')\"";
					}
				}

				$res .= '<a class="list-group-item"' . $ajax . '>' . $icon . $value . '</a>';
			}
		}

		return $res;
	}

	if(isset($_POST["folder"]))
	{
		echo(getFolderStructure($_POST["folder"]));
	}
?>
