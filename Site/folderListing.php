<?php
	include 'vars.php';

	//"Simplifie" les '..' dans le chemin $str
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
	function getFolderStructure($str, $folders)
	{
		global $musicDir;
		$str = trimPaths($str);  //On 'simplifie' le chemin spécifié (élimination des '/../', etc.)
		$t = scandir($str);     //On récupère la structure du dossier passé en paramètre
		$res = "";
		$exclude = array('.');  //Un tableau contient les valeurs à ne pas afficher
		$i = 0;
		if($str == $musicDir || $str == '../'.$musicDir)   //Si on se trouve dans le dossier racine
		{
			$exclude[] = '..';  //On n'affiche pas ..
		}

		foreach ($t as $key => $value) {                                            //Pour chacune des valeurs de $t
			if(!in_array($value, $exclude))                                         //Si l'élément actuel n'est pas exclus
			{
				$icon ='';                                                          //On initialise des trucs
				$ajax = '';
				$id = '';
				$repeatFolders = '';
				
				if($folders)
				{
					$repeatFolders = "true";
				}
				else
				{
					$repeatFolders = "false";
				}

				$echo = false;

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
					$echo = true;
				}
				else
				{
					//Formats acceptés décrits dans vars.php
					if(preg_match('/(.mp3|.ogg)$/', $value))														//Si on a une musique
					{
						$icon = '<i class="fa fa-music"></i> ';														//On met une icône de musique
						$ajax = " onclick=\"setMusic('". $str . $value . "', " . $i . ")\"";						//On rajoute un attribut pour l'AJAX (onclick="setMusic('/home/qreon/Tirelipimpon.mp3', 2)" par exemple)
						$id = " id=\"music_" . $i . "\"";															//On rajoute un id pour pouvoir se repérer dans la liste (id="music_2" par exemple)
						$i += 1;																					//On incrémente i pour la musique suivante (première valeur de i = 0)
						$echo = true;
					}
					if(is_dir($str.$value) && $folders)
					{
						$icon = '<i class="fa fa-folder-o"></i>   ';
						$ajax = " onclick=\"reloadFolderStructure('". $str . $value . "/" ."')\"";
						$echo = true;
					}
				}

				if ($echo)
				{
					$res .= '<a class="list-group-item click-cursor"' . $id . $ajax . '>' . $icon . $value . '</a>';
				}
			}
		}

		return $res;
	}

	//Renvoie le chemin de la musique situé à l'index i dans le dossier f
	function getFrom($f, $i)
	{
		$t = scandir($f);
		$return;
		$index = 0;
		$name;

		foreach ($t as $key => $value) {
			//Formats acceptés décrits dans vars.php
			if(preg_match('/(.mp3|.ogg)$/', $value))
			{
				if($i == $index)
				{
					$return = $value;
					break;
				}
				else
				{
					$return = "false";
					$index++;
				}
			}
		}

		return $return;
	}

	//Cherche dans le fichier de partage et renvoie le hash md5 du lien de la musique (ou le créé)
	function linkTo($str)
	{
		$lines = file("share.md5", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		$md5 = array();
		$path = array();
		$res = "";

		foreach ($lines as $key => $value) {
			//Le tableau est indexé par des nombres
			//Si key est pair, la ligne est un hash md5
			//Sinon c'est le chemin de la musique associée
			//on stocke les deux dans des tableau séparés
			if($key % 2 == 0)
			{
				$md5[] = $value;
			}
			else
			{
				$path[] = $value;
			}
		}

		foreach ($path as $key => $value) {
			if ($str == $value)
			{
				$res = $md5[$key];
				break;
			}
		}

		if ($res == "")
		{
			$res = md5($str);
			$file = fopen("share.md5", "a");
			fwrite($file, $res . "\n" . $str . "\n");
		}

		return $res;
	}

	//Renvoie le lien d'une musique associée à un hash
	function reverseHash($str)
	{
		$lines = file("../share.md5", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		$md5 = array();
		$path = array();
		$res = "";

		foreach ($lines as $key => $value) {
			//Le tableau est indexé par des nombres
			//Si key est pair, la ligne est un hash md5
			//Sinon c'est le chemin de la musique associée
			//on stocke les deux dans des tableau séparés
			if($key % 2 == 0)
			{
				$md5[] = $value;
			}
			else
			{
				$path[] = $value;
			}
		}

		foreach ($md5 as $key => $value) {
			if ($str == $value)
			{
				$res = $path[$key];
				break;
			}
		}

		return $res;
	}

	//Renvoie la musique demandée par un hash
	function requestedMusic()
	{
		$music = "";
		if(isset($_GET["id"]))
		{
			$hash = $_GET["id"];
			$music = '../' . reverseHash($hash);
			if(is_dir($music))
			{
				return getFolderStructure($music, false);
			}
			else
			{
				return "<a class=\"list-group-item click-cursor\" id=\"music_0\" onclick=\"setMusic('../". $music . "', 0)\"><i class=\"fa fa-music\"></i>   " . getFileName($music) . "</a>";
			}
		}

		//Si $_GET["id"] n'était pas défini ou son reverseHash n'était pas défini
		if($music != "")
		{
			return "Aucune musique chargée !";
		}
	}

	function getFileName($str)
	{
		//On sépare la chaîne
		$explode = explode("/", $str);

		//On récupère le dernier morceau ("musique.mp3")
		$filename = $explode[count($explode) - 1];

		return $filename;	
	}

	//Exécuté lors de l'appel AJAX pour la musique suivante dans le dossier, ou bien pour l'affichage de la structure d'un dossier
	if(isset($_POST["folder"]))
	{
		if(isset($_POST["index"]))
		{
			echo(getFrom($_POST["folder"], $_POST["index"]));
		}
		else
		{
			echo(getFolderStructure($_POST["folder"], true));
		}
	}

	//Exécuté lors de l'appel AJAX pour le hash d'une musique
	if(isset($_POST["share"]))
	{
		echo(linkTo($_POST["share"]));
	}
?>
