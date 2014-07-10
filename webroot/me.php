<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
 
 
// Do it and store it all in variables in the Anax container.
$eden['title'] = "Amanda om Amanda";
 

 
$eden['main'] = <<<EOD
<div class="grid">
	<h2>Hej!</h2>
	<section class="grid-2-3">
		<div class="box">
		<p>Jag heter Amanda och ska nu påbörja min andra kurs i kurspaketet. Förra kurser "Html & PHP" var i princip den första 
		kursen som jag läst i programmering sedan tidigare. Egentligen har datorer och teknik inte intresserat mig alltid, snarare
		har jag föredragit att spela teater eller måla och rita. Men när jag påbörjade min utbildning till interaktionsdesigner så
		fick jag för första gången prova på att skriva lite enklare kod. Det tog inte lång tid inna jag var fast. Nu är css-selectorer,
		if-satser och taggar mitt dagliga bröd. Än har jag en lång väg att vandra givetvis men jag har verkligen hunnit bli en nörd bara
		på denna lilla tiden. Jag älskar att lära mig mer om webbprogrammering, helt klart ett ämne som är mycket mer kreativt än jag någonsin
		kunde tänka mig. Inte bara kan jag få välja färg och form, som när jag ritar, utan jag har också kontroll över hur programmet ska
		bete sig. Det är en helt ny värld som har öppnats sig och ibland undrar jag hur det är möjligt att jag aldrig kom på hur kul det är
		att programmera tidigare.</p>
		
		<p>Att studera på distans är en annan höjdare som jag också insåg passade mig perfekt för några år sedan. Innan jag gled in på teknik, design och data
		tog jag "omvägen" om kurser i filosofi, psykologi och lite historia. Det sista jag gjorde inna jag påbörjade på utbildning var att gå ett år på konstskola
		i Argentina, där jag numera också bor.</p>
		
		<p>Ja, det var väl lite kort om mig. Nu får vi hoppas det går lika bra i denna kursen som i förra :)</p>
		</div>
	</section>
	<aside class="grid-1-3">
	<figure>
	<img src="img/amanda.jpg" alt="Bild på mig i Budapest">
	<figcaption>Bild på mig i Budapest</figcaption>
	</figure>
	</aside>
</div>
EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
