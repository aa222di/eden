<?php 
/**
 * This is a Eden pagecontroller.
 *
 */
// Include the essential config-file which also creates the $eden variable with its defaults.
include(__DIR__.'/config.php'); 
 
 
// Do it and store it all in variables in the Eden container.
$eden['title'] = "Redovisningar";
 

 
$eden['main'] = <<<EOD
<div class="grid">
	<section class="grid-2-3">
	
		<h2 id="kmom03">Kmom03</h2>
	<div class="box">
		<p>Kursmomentet kändes lärorikt och intressant. Det var bra att få koll på lite olika klienter. Dock fick jag inte igång
		workbench på min dator (kompatibilitetsproblem) så jag valde att använda phpMyAdmin för att genomföra övningarna. Guiden/Övningen
		var utmanande. Jag tyckte det var svårt att hitta i referensmanualen, sökfunktionen fungerar dåligt, i alla fall för min del. När 
		Jag söker får jag ofta upp japanska, tyska, spanska eller koreanska resultat. Förstår inte riktigt varför. Så istället har det blivit
		mycket bläddrande och letande i innehållsförteckningen. Det var tacksamt när det fanns direktlänkar, dessa sparade jag även undan i samma
		fil som jag sparade lösningarna för uppgifterna. Jag har tidigare bara arbetat med SQLite när jag läste första kursen ur kurspaketet. Tack vare
		de ringa förkunskaper så kände jag faktiskt igen en hel del, dvs. select, update, delete, insert into och order by och distinct var alla uttryck jag
		kände att jag hade någorlunda koll på. Dock får jag ofta syntaxfel. Det kan vara ett komma på fel ställe eller att jag
		har använt '' utan anledning eller missat att använda. Jag tyckte ofta att det är otydligt i manualen hur man konkret ska skriva sin query
		men när jag kommit till slutet av övningen hade jag börjat få lite mer koll på själva syntaxdelen. Det hjälpte att börja indentera och lägga
		olika queries på olika rader för att strukturera upp koden. Något som blev krångligt i slutet var att hålla reda på alla namn.
		Det blev mycket bytande fram och tillbaka mellan olika förnster för att kolla vad jag döpt de olika vyerna och tabellerna till; om det var stor eller
		liten bokstav, å eller a osv. Jag måste nog sätta en viss standard att hålla mig till annars kan det bli riktigt virrigt har jag på känn.</p>
		<p> Kurslitteraturen har varit till stor hjälp, kul med en bok på svenska, känns enklare att ta till sig även om engelskan har övats flitigt på
		sistone i och med php-manualen. Måste dock säga att jag tycker att php-manualen är mycket tydligare och mer lätthanterlig än MySQL-manualen.
		Men det har säkert att göra med att det finns mycket okända variabler i den sistnämnda vilket ibland gör texterna svårlästa för att inte nämna
		informationssökningen.</p>
	</div>
	<hr>
	
	<h2 id="kmom02">Kmom02</h2>
	<div class="box">
		<img class="grid-1-2" src="img/UML.png" alt="UML-diagram">
		<p>Under detta kursmoment fick jag för första gången börja bekanta mig med objektorienterad programmering. Jag hade tidigare hört talas som begreppet
		men aldrig ens förstått vad det handlade om. Jag arbetade igenom guiden steg för steg. Det hjälpte verkligen, men det var först när jag var tvungen att själv
		organisera min kod i uppgiften "Tärningspelet 100" som bitarna verkligen började falla på plats. Jag kan se fördelarna med objektorienterad programmering
		vilka är, så som jag tolkar det nu, framförallt att koden blir mycket mer strukturerad och uppmanar till att skriva återanvändbarkod. Vad jag också upptäckte
		var att just detta med att skriva återanvändbar kodinte är så enkelt som man kan tänka sig. Jag tyckte det var svårt att veta vilken kod jag borde
		lägga i vilken klass många gånger.</p>
		
		
		
		<p>Jag började med att kopiera mycket av det som vi hade skapat tillsammans i guiden oophp20. Sedan rensade jag bort sådant som jag antog inte skulle bli
		aktuellt för den applikation som jag skulle skapa, till exempel åkte funktionen för medelvärde bort. Idén var att kunna börja med ett så tomt blad som möjligt.
		När jag hade kommit så pass lång hade jag två klasser: CDice och CDiceImage. I CDice låg metoden för att rulla tärningen och räkna ut summan av sagen. CDiceImage
		innehöll endast metoden för att skapa bildmaterialet. Jag behövde nu något typ av funktion som skulle kunna hålla reda på spelets regler. Jag valde att skapa en ny
		klass som jag döpte till CGame. I dne klassen lade jag till de metoder jag behövde för att del hålla reda på hela spelets resultat (GameSum) samt räkna
		antalet utförda rundor. Jag lyckades dessutom få til det så att det i klassen kontrollerades att du inte nått maxPoint, dvs. 100 poäng. I så fall skulle
		ett meddelande skrivas ut och berätta att du vunnit.</p>
		
		
		
		<p>Jag ville absolut göra extrauppgifterna men på grund av tidsbrist kände jag att jag måste gå vidare med nästa kursmoment. Dock hann jag i alla fall göra om spelet
		så att man kunde välja mellan att spela ensam eller mot en kompis. Jag tyckte det var svårt att strukturera upp vad som behövde göras och var jag skulle lägga
		de nya metoderna så jag började med att rita upp ett (kanske ganska godtyckligt) UML-diagram för att få koll på hur min kod var strukturerad. Sedan skapade jag en ny klass
		som jag döpte till CPlayer. I denna klass lade jag till ett par medlemsvariabel som skulle ha koll på varje spelares poäng, vems tur det var
		och samtidigt passade jag på att flytta över ytterligare lite av spellogiken, t.ex. vad som händer om man slår en etta. Resultatet blev ett tärningspel som
		man på eden. kan spela själv eller med en kompis. Dock kan man med de klasser jag byggt välja att ändra antalet spelare till ännu fler och även ändra maxpoängen.
		Dock valde jag att begränsa dessa möjligheter på min sida.</p>
		
		<p>Ja, tyvärr kom jag aldrig längre. Det hade varit spännande att försöka bygga en datadriven spelare. Jag hade då tänkt mig att bygga en egen klass till den och 
		lägga den som en subklass till CPLayer kanske...? Nej, jag vet inte, det tål att tänkas på. Vore kul att få någon kommentar på om jag är på rätt väg gällande den struktur
		jag har på koden nu. För något av det svåraste har varit just att dela upp koden rätt. Jag känner att det lätt blir en väldigt smal applikation och det är svårt att göra koden
		mer allmängiltig.</p>
		
		<p>Komplettering:</P>
		<P>Bland mina klasser finns det ingen specifik klass som hanterar rundan utan med hjälp av metoden Play() som ligger i CPlayer slås varje slag av spelaren. 
		Play() kollar så att spelaren inte slår en etta. Slås en etta så avslutas rundan och turen går vidare (ChangePlayer()). Trycker spelaren på "Spara poäng" 
		så körs även då metoder ChangePlayer() men detta styrs alltså från page controllern. Jag blev ju ombedd att flytta över mer av koden från min
		page controller till mina klasser. Men jag körde fast. Jag upplevde det väldigt svårt att ta rätt beslut om hur och vad som borde flyttas över eftersom
		vissa delar bygger på att objektet lagras i SESSION. Till slut bad jag om hjälp i forumet och fick till svar att jag inte skulle ha GET och POST i alla fall
		i mina klasser. Så, nu är jag ganska förvirrad. Men i vilket fall så fixade jag de andra felen som fanns och testar nu på uppmaning från Mikael att
		lämna in igen. Skulle dock hemskt gärna få en kommentar på detta med GET, POST och SESSION. (Länk till forumtråden http://dbwebb.se/forum/viewtopic.php?f=37&t=2412)
		</p>
		
	</div>
	<hr>
	<h2  id="kmom01">Kmom01</h2>
	
		<div class="box">
		<p>I detta kursmomentet var det både en del repetition samtidigt som mycket kändes nytt. Första delen av guiden 
		php20 kände jag igen från kursen html/php däremot smög det sig in lite nyheter här och var också. Till exempel den 
		korta syntaxen för if-satser och php-kommandon. Jag lade egentligen ganska mycket tid på samtliga övningar i detta 
		kursmoment eftersom jag ville försäkra mig om att jag var på det klara med vad man förväntades förstå och inte.</p>
		
		<p>Att bygga upp "eden." efter Anax var både roligt och utmanande. I början kändes det lite vingligt. Även fast artikeln
		är mycket pedagogisk så var det inte förrän jag såg säcken knytas ihop i index.tpl.php som jag förstod hur allt skulle
		börja hänga ihop. Det känns så kul att få bygga upp något efter en sådan genomtänkt mall. Smidigt att det enda innehåll 
		som repeteras på en sida är delen när jag inkluderar config.php och EDEN_THEME_PATH. Jag ville genast börja bygga ut
		grunden med en css-fil som skulle vara lika kort och enkel. Jag har därför lagt lite oproportionerligt mycket tid på att
		hitta en bra grid-lösning och ett så avskalat gränssnitt som möjligt. Min förhoppning är att delar av den CSS jag använder
		kommer kunna återanvändas senare i projektet. Jag fick också ta mig en funderare på hur mycket divs och klasser jag ville
		ha i index.tpl.php. Jag tog fasta på Mikaels idé att den filen skulle vara så kort som möjligt, så även om jag experimenterade
		men att lägga in lite olika divs i headern til exempel så resulterade det hela i slutändan i en annu mer avskalad version
		än den jag började med.</p>
		
		<p>Det har även blivit lite tjuvläsning om klasser och objekt under denna tiden. Innan hade jag ingen aning om vad objekt och
		klasser var men nu efter att ha läst på lite i kurslitteraturen tycker jag det mesta känns naturligt. Därmed absolut inte sagt 
		att jag förstår allt, men till skillnad från vad jag trodde så känns det som ett vettigare och i längden enklare sätt att 
		programmera på.</p>
		
		<p>Egentligen stötte jag faktiskt inte på några stora problem under momentet i de obligatoriska delarna. Givetvis hände det att
		något semikolon fattades men kursmaterialet var enkelt att följa. Jag jobbade igenom allt så som det rekomenderades och när
		jag väl hade all kod på min egen maskin så började jag så försiktigt jag bara kunde att ändra på små saker för att se vad som hände.
		Dock försvann tyvärr(!) en otroligt massa tid pga Git och GitHub. Jag är så arg och irriterad över detta men ser heller ingen lösning.
		Jag började att göra hela guiden som ligger ute på youtube men stötte på problem i varje steg. Anledningen är att jag sitter på 
		en 5 år gammal dator med lika gammalt operativsystem. Så först kunde jag inte ens hitta en version av Git som var kompatibel. Till
		slut lyckades jag dock ladda ner en version från 2009, men då funkar ju givetvis inte de kommandon som mos använder. Så hel en dag 
		gick åt till att läsa på stackoverflow och i gits gamla manualer. När jag väl hittat ett flertal lösning som enligt 
		konstens alla regler borde fungera så fick jag bara tillbaka som svar att jag inte kunde pusha upp för att GitHub la på luren ungefär.
		Svårt att se den positiva sidan. Men förr eller senare så dyker man väl på sådana olösliga problem. Jag har dock en idé om att ladda 
		upp hela mitt projekt på cloud9.io och därifrån pusha in det på GitHub för att även ha det lagrat på en extern server och inte bara på min
		egen dator. Men just nu orkar jag inte en se octocat och hans vänner så det får bli något jag löser längre fram. Det gick ju faktiskt
		bra att ladda ner CSource som zip och implementera det. </p>
		
		<p>Program som jag använder</p>
		<p>
		OP: Mac OS X 10.5.8</p>

		<p>Mest använda webbläsare: Firefox och Safari</p>

		<p>Webbserver: mamp</p>
		
		<p>Editor: jEdit</p>

		<p>sftp-klient: Filezilla</p> 
		</div>
	</section>
	<aside class="grid-1-3">
	<h2>Innehåll</h2>
	<ul>
		<li><a href="#kmom01" title="Kmom01">Kmom01</a></li>
		<li><a href="#kmom02" title="Kmom02">Kmom02</a></li>
		<li><a href="#kmom03" title="Kmom02">Kmom03</a></li>
		<li>Kmom04</li>
		<li>Kmom05</li>
		<li>Kmom06</li>
		<li>Kmom07</li>
	</ul>
	
	</aside>
</div>
EOD;
 

 
 
// Finally, leave it all to the rendering phase of Eden.
include(EDEN_THEME_PATH);
