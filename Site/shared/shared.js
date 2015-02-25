var music;
var stopCount = false;
var rangeMax;

var musicPath = "";
var musicIndex;
var musicFolder = "music/";

function g(id){
	return document.getElementById(id);
}

soundManager.onload = function(){
	//Pas de musique chargée
	g("musicInfo").innerHTML = "Aucune musique";
}

function setMusic(str, i)
{
	if(music != null)
	{
		music.destruct();
	}
	var name = getFileName(str);
	music = soundManager.createSound(
		{
			id : "currentMusic",
			url : str,
			onload : function()
			{
				musicPath = str;
				musicFolder = getFolder(str);
				musicIndex = i;

				g("musicInfo").innerHTML = name;
				g("dlDiv").innerHTML = "<a class=\"btn btn-danger\" id=\"dlBtn\" href=\"" + musicPath + "\" download><i class=\"fa fa-download\"></i></a>"
				g("shrDropup").innerHTML =	"<li id=\"shrMusic\" onclick=\"share('"+ musicPath +"');\"><a href=\"#\">Partager la musique</a></li>"+
											"<li id=\"shrFolder\" onclick=\"share('"+ musicFolder +"');\"><a href=\"#\">Partager le dossier</a></li>";
			},
			whileplaying : function() {
				updateDisplay();
			},
			onfinish : function() {
				requestFor(musicFolder, musicIndex+1);
				if (nextMusic == "false")
				{
					music.setPosition(0);
					g("playDiv").innerHTML = "<button class=\"btn btn-lg btn-default\" onclick=\"play();\" id=\"playBtn\"><i class=\"fa fa-play\"></i></button>";
					updateDisplay();
				}
				else
				{
					setMusic(musicFolder + nextMusic, musicIndex+1);
				}
			}
		}
	);
	unmute(true);
	play(true);
}

function play(force){  			//Joue la musique
	force = typeof force !== 'undefined' ? force : false;	//La méthode javascript cradingue pour les paramètres par défaut
	if(music.paused || force)
	{
		music.play();
		g("playDiv").innerHTML = "<button class=\"btn btn-lg btn-default\" onclick=\"pause();\" id=\"playBtn\"><i class=\"fa fa-pause\"></i></button>";
	}
}

function pause(){    			//Met en pause la musique
	if(!music.paused)
	{
		music.pause();
		g("playDiv").innerHTML = "<button class=\"btn btn-lg btn-default\" onclick=\"play();\" id=\"playBtn\"><i class=\"fa fa-play\"></i></button>";
	}
}

function unmute(force){ 		//Met le son
	force = typeof force !== 'undefined' ? force : false;
	if(music.muted || force)
	{
		music.unmute();
		g("volDiv").innerHTML = "<button class=\"btn btn-lg btn-default\" onclick=\"mute();\" id=\"playBtn\"><i class=\"fa fa-volume-up\"></i></button>";
	}
}

function mute(){				//Coupe le son
	if(!music.muted)
	{
		music.mute();
		g("volDiv").innerHTML = "<button class=\"btn btn-lg btn-default\" onclick=\"unmute();\" id=\"playBtn\"><i class=\"fa fa-volume-off\"></i></button>";
	}
}

function updateDisplay()
{
	var dur = parseInt(music.duration/1000, 10);
	var durMin = parseInt(dur/60, 10);
	var durSec = dur%60;

	var pos = parseInt(music.position/1000, 10);
	var posMin = parseInt(pos/60, 10);
	var posSec = pos%60;

	if (posMin < 10)
	{
		posMin = "" + "0" + posMin.toString();
	}
	if (posSec < 10)
	{
		posSec = "" + "0" + posSec.toString();
	}
	if (durMin < 10)
	{
		durMin = "" + "0" + durMin.toString();
	}
	if (durSec < 10)
	{
		durSec = "" + "0" + durSec.toString();
	}

	var displayDur = durMin.toString() + ":" + durSec.toString();
	var displayPos = posMin.toString() + ":" + posSec.toString();

	g("timeCpt").innerHTML = displayPos + " / " + displayDur;

	if(!stopCount)						//On a parfois besoin d'arrêter l'actualisation de la position du slider pour ne pas gêner les manip utilisateur
	{
		var curPos = parseInt(pos / dur * rangeMax, 10);
		g("timeRange").innerHTML = "<input id=\"time\" type=\"range\" value=\"" + curPos.toString() + "\" min=\"0\" max=\"" + rangeMax.toString() + "\" onmousedown=\"rangePressed()\" onmouseup=\"rangeReleased()\">";
	}
}

function rangePressed()
{
	stopCount = true;
}

function rangeReleased()
{
	//val est compris entre 0 et rangeMax, il faut le traiter avant de s'en servir
	var val = parseInt(g("time").value, 10);
	var dur = parseInt(music.duration, 10);
	var value = dur * (val / rangeMax);
	value = Math.round(value * 100) / 100 	//Arrondissement à 2 décimales max
	music.setPosition(value);

	stopCount = false;
}

function dl()
{
	window.location = musicPath;
}

function setRangeMax(){
	rangeMax = parseInt(g("time").max, 10);
}

function getFileName(str){
	//On sépare la chaîne
	var explode = str.split("/");

	//On récupère le dernier morceau ("musique.mp3")
	var filename = explode[explode.length - 1];

	//On sépare ce dernier morceau
	var noExt = filename.split(".");

	//On vire l'extension
	noExt.pop();

	//On renvoie la chaine avant l'extension
	return noExt.join(".");
}

function getFolder(str){
	var explode = str.split("/");		//On découpe sur les /
	explode[explode.length - 1] = "";	//On efface la dernière case
	return explode.join("/");			//On renvoie un chemin avec un / au bout
}

if (document.addEventListener)
	document.addEventListener("DOMContentLoaded", setRangeMax, false);