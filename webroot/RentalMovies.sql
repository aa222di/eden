CREATE DATABASE  IF NOT EXISTS `projectrm` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `projectRM`;
-- MySQL dump 10.13  Distrib 5.6.17, for osx10.6 (i386)
--
-- Host: 127.0.0.1    Database: projectRM
-- ------------------------------------------------------
-- Server version	5.5.34

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ContentRM`
--

DROP TABLE IF EXISTS `ContentRM`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ContentRM` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` char(80) DEFAULT NULL,
  `url` char(80) DEFAULT NULL,
  `category` char(80) DEFAULT NULL,
  `type` char(80) DEFAULT NULL,
  `title` varchar(80) DEFAULT NULL,
  `data` text,
  `filter` char(80) DEFAULT NULL,
  `published` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ContentRM`
--

LOCK TABLES `ContentRM` WRITE;
/*!40000 ALTER TABLE `ContentRM` DISABLE KEYS */;
INSERT INTO `ContentRM` (`id`, `slug`, `url`, `category`, `type`, `title`, `data`, `filter`, `published`, `created`, `updated`, `deleted`) VALUES (1,'maleficent',NULL,'Reviews','post','Maleficent','\'\'Let us tell an old story anew and see how well you know it.\'\' The first line of Maleficent could be emblazoned on a sticker and slapped onto the back-bumper of Hollywood, an industry that has at this point become more interested in recycling than Ed Begley, Jr. The classic movies, characters, and franchises of the past are dead dinosaurs that have since turned into precious, commodifiable oil, and no one is sitting on top of a richer reservoir than Disney. The latest to come galloping out of the vault is Maleficent, which casts Angelina Jolie — somehow made more angular and aloof — as one of the studio\'s great animated villains, the horned epitome of evil from 1959\'s Sleeping Beauty. As with other perspective-switch narratives like Grendel or Wide Sargasso Sea (or even Wicked) the film exists to fill in the cracks of the original story, giving context to a character\'s antagonism. Betrayed by her childhood love (Sharlto Copley) so that he could become king, Maleficent curses the princess Aurora (Elle Fanning): She will prick her finger on a spinning wheel by her 16th birthday and fall into a death-like sleep. The hex is one made by a woman scorned and, according to this revisionist fairy tale, soon regretted, as the cuddlier version of the villainess becomes a reluctant fairy godmother to Aurora.\r\n\r\nRobert Stromberg, the production designer responsible for the horizon-less CGI dreamscapes of Alice in Wonderland, Oz: The Great and Powerful, and Avatar, makes his directorial debut and — surprise! — there\'s a lot of levitating cliffs and odd flora. But despite their bleeding-edge digital design, the backgrounds have all the depth of the old matte-painted backgrounds of the analog days. That might not be an accident, since a lot of Maleficent feels classical in nature. The characters are boiled down to their essentials, the humor is timelessly broad, and Jolie\'s at her best when she\'s curling her claws and elongating her vowels like a black-sabbath Tallulah Bankhead. Unfortunately, the story is more than a bit of a muddle, a string of sequences that shuttle the characters back and forth between the film\'s sole two locations, a castle and a magic forest. And somehow, there\'s only enough time for Sleeping Beauty to get five minutes of shut-eye before she\'s almost immediately awoken by true love\'s kiss. That\'s not a death-like sleep, that\'s a power nap','nl2br,markdown','2014-08-16 14:32:37','2014-08-16 13:32:37',NULL,NULL),(2,'gravity',NULL,'Reviews','post','Gravity','Alfonso Cuarón\'s incredibly exciting, visually amazing film is about two astronauts floating in space. The title refers to the one big thing almost entirely absent from the film: it\'s like The Seventh Seal being called Levity or Last Tango in Paris Chastity. With gorgeous, tilting planet Earth far below in its shimmering blue aura, a bulkily suited spaceman and spacewoman veer, swoop and swerve in woozy slo-mo as they go about their business tethered to the station, like foetuses still attached to their umbilical cords. The movie\'s final sequence hints at some massive cosmic rebirth; a sense that these people are the first or last human beings in the universe, like something by Kubrick.','nl2br,markdown','2014-08-16 13:33:37','2014-08-16 13:32:37',NULL,NULL),(3,'new-website',NULL,'Rental Movies','post','New Website!','### We are happy to announce our new website! \r\n\r\nAfter a lot of work we have finally finished our new website. Our hope is that you fill now easily find your favourite movies and the right information about them. We can also offer you a very beneficial membership right now. As a member you will get a 1 dollar discount on all our movies! ','nl2br,markdown','2014-08-16 13:32:39','2014-08-16 13:32:37',NULL,NULL),(4,'robin-williams-dead',NULL,'Celebirty news','post','Robin Williams dead','Robin Williams tragically passed away, sadly taking his own life on August 11. Hollywood has been shaken by his passing, and will always remember the late actor through his gift to the world — making us laugh. \r\n\r\nRobin Williams visited Inside The Actors Studio with host James Lipton on June 10, 2001, and Bravo is re-airing his episode, as a tribute to the late actor and comedian’s life.\r\n\r\nIn the special episode, Robin impresses with his incredible improv skills, making the audience laugh with his impersonation of Iron Chef. Then he quickly transitions to take on other characters seamlessly and instantaneously.\r\n\r\n![Robin Williams](http://images3.cinema.de/imedia/9112/1719112,MqveFMRzikFV7Hc_8n63Uc1ipmVb1vLp9msrFhS3XaFwpWgi6UYEvgJgPeOS3+TzP7qqwCcLyODdR79920XjOw==.jpg \"Robin Williams\")\r\n\r\nAt the time of the 250th episode, fans voted Robin’s appearance on the Emmy-award winning series as the fan favorite of all time. The episode is a bittersweet reminder that Robin was truly a great talent that will forever be missed.\r\n\r\nRobin Williams tragically found dead on August 11 in his home in Tiburon, California. On August 12, police confirmed that he primary cause of death is asphyxiation by hanging. The investigation is ongoing.','nl2br,markdown','2014-08-16 13:32:37','2014-08-16 13:32:37',NULL,NULL),(5,'george-clooney-engaged',NULL,'News','post','George Clooney is engaged','Sounds like George Clooney is ready to tie the knot! The actor and his fiancee made a trip to Chelsea registry office to announce their plans to marry. We are so happy for George and his girlfriend. And while speaking about Mr Clooney we urge you not to miss his latest movie [Gravity](moviesingle.php?id=10)','nl2br,markdown','2014-08-17 13:32:37','2014-08-16 13:32:37',NULL,NULL),(6,'the-life-aquatic-4-5',NULL,'Reviews','post','The Life Aquatic 4/5','There may be filmmakers more idiosyncratic than Wes Anderson - Jean-Luc Godard is still alive and shooting, after all - but there is no one who can match Mr. Anderson\'s devotion to his own idiosyncrasy. In his last movie, \"The Royal Tenenbaums\" (2001), the director and his writing partner, Owen Wilson, confected a parallel-universe Manhattan of moody tennis players, neurasthenic playwrights and rambling mansions, burying a touching story of child prodigies and prodigal parents in tchotchkes and bric-a-brac. At the time, some of us who had admired Mr. Anderson\'s first two films, \"Bottle Rocket\" and \"Rushmore,\" complained that his delicate combination of whimsy and emotional purity was sliding into preciousness.\r\n\r\n\"The Life Aquatic With Steve Zissou,\" based on a script by Mr. Anderson and Noah Baumbach, goes even further, conjuring an imaginary world that encompasses wild ocean-faring technologies and fanciful species of computer-animated fish. Rather than tacking toward the shore of realism, Mr. Anderson blithely heads for the open sea of self-indulgent make-believe. As someone who was more annoyed than charmed by \"Tenenbaums,\" I should have been completely exasperated with \"The Life Aquatic,\" with its wispy story and wonder-cabinet production design, but to my surprise I found it mostly delightful.\r\n\r\nSome of this has to do with Bill Murray, who occupies nearly every frame of the picture, usually sighing and frowning right in the middle of the screen. Mr. Anderson favors static, head-on compositions stuffed with beguiling details, and Mr. Murray holds still for him, allowing the audience\'s eyes to peruse his carefully arranged surroundings.\r\n\r\nThe actor\'s quiet, downcast presence modulates the antic busyness that encircles him, and his performance is a triumph of comic minimalism. Like Gene Hackman\'s Royal Tenenbaum, Mr. Murray\'s Steve Zissou is a flawed, solipsistic patriarch, though his defining emotion is not intemperate anger but a vague, wistful tristesse. His doughy face fringed by a grizzled Ernest Hemingway beard and topped by a red watch cap, Mr. Murray turns tiny gestures and sly, off-beat line readings into a deadpan tour-de-force, at once utterly ridiculous and curiously touching.\r\n\r\nZissou is a famous ocean explorer whose undersea adventures have less to do with scientific research than with pop-culture branding. He makes movies, administers a vast fan club, and keeps his eye out for merchandising opportunities. When we first meet him, at the premiere of his latest \"Life Aquatic\" documentary, he is beset with troubles. His trusty sidekick (Seymour Cassel) has been eaten by a mysterious shark (on which Zissou vows Ahab-like revenge) and Eleanor, his wife and business partner (Anjelica Huston), seems to be gravitating back into the orbit of her ex-husband, Alastair Hennessey (Jeff Goldblum), Zissou\'s slick, reptilian arch-rival. Meanwhile, a nosy reporter (Cate Blanchett) talks her way onto Zissou\'s boat, joined by Ned Plimpton (Mr. Wilson), a guileless, pipe-smoking young man from Kentucky who may or may not be the captain\'s long-lost illegitimate son.\r\n\r\nHaving established a rather hectic set of narrative premises (and I have provided only a partial list), Mr. Anderson proceeds to treat them casually, dropping in swatches of action and feeling when they suit his atmospheric purposes. He is less a storyteller than an observer and an arranger of odd human specimens. \"The Life Aquatic\" is best compared to a lavishly illustrated, haphazardly plotted picture book - albeit one with frequent profanity and an occasional glimpse of a woman\'s breasts - the kind dreamy children don\'t so much read start to finish as browse and linger over, finding fuel for their own reveries.\r\n\r\nThere is, to be sure, a certain willful, show-off capriciousness in this approach to filmmaking, but there is also a great deal of generosity. Mr. Anderson and Mr. Baumbach have built a magpie\'s nest of borrowed and reconditioned cultural flotsam - from Jacques Cousteau to Tintin and beyond - but the purpose of their pastiche is less to show how cool they are than to revel in, and share, a childish delight in collecting and displaying strange and enchanting odds and ends. If you allow yourself to surrender to \"The Life Aquatic,\" you may find that its slow, meandering pace and willful digressions are inseparable from its pleasures.\r\n\r\nNot that it\'s all fun and games. The bright colors and crazy gizmos are washed over with a strange, free-floating pathos that occasionally attaches itself to the characters, but that seems in the end to be more an aspect of the film\'s ambience than of its dramatic situations. Zissou\'s world-weary melancholy, the utter seriousness with which he goes about being absurd, contains an element of inconsolable nostalgia. He is a child\'s fantasy of adulthood brought to life, and at the same time an embodiment of the longing for a return to childhood that colors so much of grown-up life.\r\n\r\nIn my ideal cinémathèque, \"The Life Aquatic\" would play on a permanent double bill with \"The SpongeBob SquarePants Movie.\" Mr. Anderson and Stephen Hillenburg, Mr. Squarepants\'s creator, share not only a taste for nautical nonsense, but also a willingness to carry the banner of unfettered imaginative silliness into battle against the tyranny of maturity.\r\n\r\nThey also both understand the sublimity that well-chosen pop music can impart even to throwaway moments. The seaborne contrivances of \"The Life Aquatic\" may make you a little queasy, but the soundtrack is impossible to argue with. It consists mainly of early David Bowie songs - \"Queen Bitch,\" \"Space Oddity,\" \"Five Years\" and the like - sung samba style, in lilting Brazilian Portuguese, by Seu Jorge. Like much else in the movie, these songs seem to come from another world: one which is small, crowded and, on its own skewed terms, oddly perfect.','nl2br,markdown','2014-08-24 17:38:06','2014-08-24 18:40:04',NULL,NULL),(7,'bill-murray',NULL,'Celebirty news','post','Bill Murray','##Synopsis\r\nBorn in 1950, in Illinois, Bill Murray eventually relocated to New York City, where he took comedic talents to National Lampoon Hour. In 1975, he was in an off-Broadway spin-off of the comedy radio show when Howard Cosell recruited him for Saturday Night Live. It was on the set that he created the comedic character that became his calling card for many films to come, including Hyde Park on Hudson (2013), in which Murray plays Franklin D. Roosevelt.\r\n##Early Life\r\nActor and comedian Bill Murray was born William J. Murray on September 21, 1950, in Wilmette, Illinois. The fifth of nine children, Murray was a self-proclaimed troublemaker, whether it was getting kicked out of Little League or being arrested at age 20 for attempting to smuggle close to nine pounds of marijuana through Chicago\'s O\'Hare Airport. In an attempt to find direction in his life, he joined his older brother, Brian Doyle-Murray, in the cast of Chicago\'s Second City improvisational comedy troupe.\r\n![Young Bill Murray](http://ikono.org/cappelli/site/wp-content/uploads/Where-theBuffalo-Roam.jpg \"Young Bill Murray\")\r\n##\'Saturday Night Live\'\r\nHe eventually relocated to New York City where he took his comedic talents on air in National Lampoon Hour (1973-74) alongside Dan Aykroyd, Gilda Radner and John Belushi. In 1975, both Murray brothers were in an off-Broadway spin-off of the radio show when Bill was spotted by sportscaster Howard Cosell, who recruited him for the cast of his ABC variety program, Saturday Night Live With Howard Cosell (1975-76). On NBC, a program also named Saturday Night Live (1975-) was creating a much bigger sensation. A year later producer Lorne Michaels tapped Murray to replace Chevy Chase, who had moved on to pursue a film career.\r\n\r\nIt was on the set of Saturday Night Live that Murray created the sleazy, insincere comedic character that became his calling card for many films to come. He also earned an Emmy for Outstanding Writing for his work on the show. His first major film role was in the 1979 box office hit Meatballs. This was followed by the biography flop Where the Buffalo Roam (1980), where Murray starred as gonzo journalist Hunter S. Thompson.\r\n##Blockbuster Comedies and Hiatus\r\nMurray redeemed himself later that year by going back to his comedic roots with the cult classic Caddyshack. He continued with a string of successes on film, such as in the army farce Stripes (1981), Tootsie (1982) and Ghostbusters (1984) with Dan Aykroyd and Harold Ramis. The comedy was one of the decade\'s biggest hits, spawning a cartoon series, action figures and even a chart-topping theme song.\r\n\r\nMurray\'s next move caught loyal fans off guard. He starred in and co-wrote an adaptation of the W. Somerset Maugham novel The Razor\'s Edge in 1984, which had been a lifelong dream. The hairpin turn from farce to literary drama proved too sharp, and the film was a failure. Murray spent the next several years away from Hollywood, only making a cameo appearance in the 1986 musical comedy Little Shop of Horrors.\r\n##Comeback\r\nMurray finally made his comeback in 1988 with Scrooged, a darkly comedic version of Dickens\' A Christmas Carol (1843). While it performed moderately well, it was not the smash many predicted—nor was 1989\'s Ghostbusters II. But in 1991, he starred in What About Bob?, which was an unqualified hit, followed by the equally acclaimed Groundhog Day in 1993 and Ed Wood in 1994.','nl2br,markdown','2014-08-24 17:41:39','2014-08-24 18:45:57',NULL,NULL),(8,'sophia-coppola-to-direct-the-little-mermaid',NULL,'News','post','Sophia Coppola to Direct The Little Mermaid','####EXCLUSIVE: \r\nSofia Coppola is negotiating to direct The Little Mermaid, a live-action version of the classic Hans Christian Anderson fairy tale for Universal Pictures and Working Title partners Tim Bevan and Eric Fellner. Caroline Thompson of Edward Scissorhands fame is rewriting the script, about the mermaid willing to make a Faustian bargain to live on land after she falls in love. Previous drafts were done by Fifty Shades Of Grey scribe Kelly Marcel and Shame scribe Abi Morgan, and Joe Wright was at one time eyeing this to direct.\r\n\r\n![Sophia directing a movie](http://www.soundonsight.org/wp-content/uploads/2013/06/female-directors-sofia-coppola.jpg \"Sophia on the set\")\r\n\r\nThe intention is to move quickly. This is a departure for Coppola in that her projects are usually focused on adult themes. She’s got kids and it wouldn’t be shocking if she wanted to please them with a movie they can see and understand. Working Title is currently in production on Everest, the drama about the climbing disaster. The director is repped by ICM Partners and attorney Barry Hirsch. ICM also reps Thompson. Coppola last helmed The Bling Ring','nl2br,markdown','2014-08-24 18:09:38','2014-08-24 19:13:30',NULL,NULL),(9,'sarah-polley-makes-film-about-her-family',NULL,'News','post','Sarah Polley makes film about her family','For years, it has been Sarah Polley’s most closely guarded secret. And if ever there were a need for a spoiler alert, this is it.\r\n\r\nAudiences who want to appreciate fully the artistry of the gradual revelations in Ms. Polley’s new film, Stories We Tell, should read no further but, as Ms. Polley herself confessed in a blog post on Wednesday, the film is about her parentage.\r\n\r\nAfter years of family jokes and rumours about the parentage of the youngest family member, Ms. Polley discovered in 2006 that she was the product of an affair her mother, actress Diane Polley, had in the 1970s.\r\n\r\nThe filmmaker, who earned her status as Canada’s sweetheart in the TV program Road to Avonlea and was nominated for an Oscar for her film Away From Her, has kept that discovery a secret – even waiting a year before telling the man who raised her.\r\n![Polley directing](http://www.cinematraque.com/wp-content/uploads/2013/05/stories-we-tell-sarah-polley-sul-set-249784.jpg \"Sarah directing\")\r\nUntil now. Ms. Polley broke her silence ahead of her film’s North American premiere at the Toronto International Film Festival on Sept. 7.\r\n\r\n“It was a story that I had kept secret from many people in my life, including my father,” Ms. Polley writes in a post on the National Film Board of Canada website. “He was not my biological father. This had been confirmed by a DNA test. … I had met my biological father almost by accident, though I had long suspected based on family jokes and rumours that my mother may have had an affair that led to my conception.”\r\n\r\nThe subject of the documentary has been the topic of much media speculation in recent months because Ms. Polley and her co-producer, the NFB, have been extremely secretive about its content. Ms. Polley has refused all interviews, while the NFB has said only that Stories We Tell contains documentary elements and shows different family members offering differing accounts of their history. Journalists were left guessing that Ms. Polley’s subject was her family.\r\n\r\nIn the blog post, she describes meeting her biological father and making friends with him, but keeping his existence a secret from Michael Polley, who had raised her single-handedly after her mother’s death in 1990, until she became concerned that he would learn it elsewhere. “My father’s response to this staggering piece of news was extraordinary,” she writes in the blog. “He has always been a man who responds to things in unusual ways, for better or for worse. He was shocked, but not angry. ... His chief concern, almost immediately, was that my siblings and I not put any blame on my mother for her straying outside of their marriage.”\r\n\r\nAs Ms. Polley acknowledges on the blog, it is a common enough story – and yet there is nothing common about her film, which on Wednesday made its world premiere at the Venice Film Festival. Ms. Polley, who appears on camera interviewing her siblings, her fathers, her aunts and her mother’s old friends, positions the film as an investigation into family history, taking as her theme the unreliability of memory and the contradictions in different people’s experiences of the same events.\r\n![The new film](http://37.media.tumblr.com/f97da3504bb62cf526929a8ca16c00dd/tumblr_n6qkd3UFMU1rsmxqlo1_1280.jpg \"Stories We Tell\")\r\nSome of this is in the film, some dispute about whose story this really is, some disagreement about whether the gregarious and spirited Diane was an open book or a woman with secrets; whether Michael was an attentive husband and father or a cold fish; whether he was the love of Diane’s life or another of its disappointments. Probably he was both. This film, most of all, is Ms. Polley’s sensitive quest for all three missing parents; in their turn, the two who are still living are remarkably generous in their willingness to be found. And the one who is gone is brought remarkably to life through the device of old Super 8 films. At some point, these silent family movies give way to ingeniously staged recreations that take Diane off to Montreal and the affair; it may be this device that has made the NFB hesitate to call the film a documentary, but the moment when real gives way to recreated, when actors take over from Polleys, is so artful it is all but indiscernible. (Cast by Sarah’s half-brother, John Buchan, the film is a great testament to another branch of the family show business: Diane was also a casting director.)\r\n\r\nAt just the right moment, Ms. Polley skillfully fesses up to the recreations, but there is no sense of duping the audience here. Instead, there’s a thematic consistency as life gives way to art. Similarly, if the film seems to wander about looking for its conclusion, that quest feels like Ms. Polley’s own, unfinished story. Family, after all, is for life.','nl2br,markdown','2014-08-24 18:34:52','2014-08-24 19:38:23',NULL,NULL),(10,NULL,'about-us',NULL,'page','About Us','<p>Rental Movies is a company with a great passion for movies, filmstars and good stories. We have had a little shop in a small town for more than 15 years but are now very happy to be able to also exist on the web. We hope that you will find all your favourite movies in our catalogue, and if you don\'t, please tell us so we can get better!</p>\r\n\r\n<p>Don\'t forget to get yourself a free membership. As a member you get a discount on your rentals and a profile page on our webpage.</p>','nl2br,markdown','2014-08-24 18:34:52','2014-08-24 19:38:23',NULL,NULL);
/*!40000 ALTER TABLE `ContentRM` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genresRM`
--

DROP TABLE IF EXISTS `genresRM`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `genresRM` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genresRM`
--

LOCK TABLES `genresRM` WRITE;
/*!40000 ALTER TABLE `genresRM` DISABLE KEYS */;
INSERT INTO `genresRM` (`id`, `name`) VALUES (3,'action'),(4,'adventure'),(6,'comedy'),(2,'drama'),(7,'family'),(5,'horror'),(1,'romance'),(9,'sci-fi'),(8,'thriller');
/*!40000 ALTER TABLE `genresRM` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table `moviesRM`
--

DROP TABLE IF EXISTS `moviesRM`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moviesRM` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `info` text,
  `director` varchar(45) DEFAULT NULL,
  `year` int(4) DEFAULT '1900',
  `price` varchar(45) NOT NULL DEFAULT '40',
  `img` varchar(45) DEFAULT NULL,
  `trailer` varchar(45) DEFAULT NULL,
  `link` varchar(45) DEFAULT NULL,
  `imgfolder` varchar(45) DEFAULT NULL,
  `lastedit` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `title_UNIQUE` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moviesRM`
--

LOCK TABLES `moviesRM` WRITE;
/*!40000 ALTER TABLE `moviesRM` DISABLE KEYS */;
INSERT INTO `moviesRM` (`id`, `title`, `info`, `director`, `year`, `price`, `img`, `trailer`, `link`, `imgfolder`, `lastedit`) VALUES (1,'The Darjeeling Limited','A year after the accidental death of their father, three brothers -- each suffering from depression - meet for a train trip across India. Francis, the eldest, has organized it. The brothers argue, sulk, resent each other, and fight. The youngest, Jack, estranged from his girlfriend, is attracted to one of the train\'s attendants. Peter has left his pregnant wife at home, and he buys a venomous snake. After a few days, Francis discloses their surprising and disconcerting destination. Amid foreign surroundings, can the brothers sort out their differences? A funeral, a meditation, a hilltop ritual, and the Bengal Lancer figure in the reconciliation.','Wes Anderson',2007,'3.9','darjeelingDVD.jpg','http://youtu.be/eI8UWewnpGs','http://www.imdb.com/title/tt0838221/?ref_=nv_','darjeelinglimited','2014-08-27 10:18:11'),(2,'Life Aquatic','When his partner is killed by the mysterious and possibly nonexistent Jaguar Shark, Steve Zissou and his Team Zissou crew set off for an expedition to hunt down the creature. Along with his estranged wife, a beautiful journalist and a co-pilot who could possibly be Zissou\'s son, the crew set off for one wild expedition','Wes Anderson',2004,'3.49','lifeaquaticDVD.jpg','http://youtu.be/_INNTuDxT58','http://www.imdb.com/title/tt0362270/?ref_=nv_','lifeaquatic','2014-08-28 11:33:20'),(3,'No Country for Old Men','In rural Texas, welder and hunter Llewelyn Moss discovers the remains of several drug runners who have all killed each other in an exchange gone violently wrong. Rather than report the discovery to the police, Moss decides to simply take the two million dollars present for himself. This puts the psychopathic killer, Anton Chigurh, on his trail as he dispassionately murders nearly every rival, bystander and even employer in his pursuit of his quarry and the money. As Moss desperately attempts to keep one step ahead, the blood from this hunt begins to flow behind him with relentlessly growing intensity as Chigurh closes in. Meanwhile, the laconic Sherrif Ed Tom Bell blithely oversees the investigation even as he struggles to face the sheer enormity of the crimes he is attempting to thwart. ','Ethan Coen, Joel Coen',2007,'3.9','nocountryforoldmenDVD.jpg','http://youtu.be/YOohAwZOSGo','http://www.imdb.com/title/tt0477348/?ref_=nv_','nocountry','2014-08-27 15:47:46'),(4,'Inglourious Basterds','In Nazi-occupied France, young Jewish refugee Shosanna Dreyfus witnesses the slaughter of her family by Colonel Hans Landa. Narrowly escaping with her life, she plots her revenge several years later when German war hero Fredrick Zoller takes a rapid interest in her and arranges an illustrious movie premiere at the theater she now runs. With the promise of every major Nazi officer in attendance, the event catches the attention of the \"Basterds\", a group of Jewish-American guerilla soldiers led by the ruthless Lt. Aldo Raine. As the relentless executioners advance and the conspiring young girl\'s plans are set in motion, their paths will cross for a fateful evening that will shake the very annals of history.','Quentin Tarantino',2009,'3.9','inglouriousbasterdsDVD.jpg','http://youtu.be/6AtLlVNsuAc','http://www.imdb.com/title/tt0361748/?ref_=nv_','inglouriousbasterds','2014-08-27 15:48:59'),(5,'Moonrise Kingdom',' Set on an island off the coast of New England in the 1960s, as a young boy and girl fall in love they are moved to run away together. Various factions of the town mobilize to search for them and the town is turned upside down -- which might not be such a bad thing. ','Wes Anderson',2012,'5.49','moonrisekingdomDVD.jpg','http://youtu.be/_eOI3AamSm8','http://www.imdb.com/title/tt1748122/?ref_=nv_','moonrisekingdom','2014-08-28 11:32:31'),(6,'Burn After Reading','Osbourne Cox, a Balkan expert, is fired at the CIA, so he begins a memoir. His wife wants a divorce and expects her lover, Harry, a philandering State Department marshal, to leave his wife. A diskette falls out of a gym bag at a Georgetown fitness center. Two employees there try to turn it into cash: Linda, who wants money for elective surgery, and Chad, an amiable goof. Information on the disc leads them to Osbourne who rejects their sales pitch; then they visit the Russian embassy. To sweeten the pot, they decide they need more of Osbourne\'s secrets. Meanwhile, Linda\'s boss likes her, and Harry\'s wife leaves for a book tour. All roads lead to Osbourne\'s house.','Ethan Coen, Joel Coen',2008,'3.9','burnafterreadingDVD.jpg','http://youtu.be/SVCHSiRWjJM','http://www.imdb.com/title/tt0887883/?ref_=nv_','burnafterreading','2014-08-27 15:48:13'),(7,'Kill Bill vol. 1','The lead character, called \'The Bride,\' was a member of the Deadly Viper Assassination Squad, led by her lover \'Bill.\' Upon realizing she was pregnant with Bill\'s child, \'The Bride\' decided to escape her life as a killer. She fled to Texas, met a young man, who, on the day of their wedding rehearsal was gunned down by an angry and jealous Bill (with the assistance of the Deadly Viper Assassination Squad). Four years later, \'The Bride\' wakes from a coma, and discovers her baby is gone. She, then, decides to seek revenge upon the five people who destroyed her life and killed her baby. The saga of Kill Bill Volume I begins.','Quentin Tarantino',2003,'3.49','killbill1DVD.jpg','http://youtu.be/ot6C1ZKyiME','http://www.imdb.com/title/tt0266697/?ref_=nv_','killbill','2014-08-27 15:52:51'),(8,'Kill Bill vol. 2','The murderous Bride is back and she is still continuing her vengeance quest against her ex-boss, Bill, and taking aim at Bill\'s younger brother Budd and Elle Driver, the only survivors from the squad of assassins who betrayed her four years earlier. It\'s all leading up to the ultimate confrontation with Bill, the Bride\'s former master and the man who ordered her execution!','Quentin Tarantino',2004,'3.49','killbill2DVD.jpg','http://youtu.be/q2h6EFk36kI','http://www.imdb.com/title/tt0378194/?ref_=tt_','killbill','2014-08-27 15:52:37'),(9,'A Serious Man','Bloomington, Minnesota, 1967: Jewish physics lecturer Larry Gopnik is a serious and a very put-upon man. His daughter is stealing from him to save up for a nose job, his pot-head son, who gets stoned at his own bar-mitzvah, only wants him round to fix the TV aerial and his useless brother Arthur is an unwelcome house guest. But both Arthur and Larry get turfed out into a motel when Larry\'s wife Judy, who wants a divorce, moves her lover, Sy, into the house and even after Sy\'s death in a car crash they are still there. With lawyers\' bills mounting for his divorce, Arthur\'s criminal court appearances and a land feud with a neighbour Larry is tempted to take the bribe offered by a student to give him an illegal exam pass mark. And the rabbis he visits for advice only dole out platitudes. Still God moves in mysterious - and not always pleasant - ways, as Larry and his family will find out. ','Ethan Coen, Joel Coen',2009,'3.9','aseriousmanDVD.jpg','http://youtu.be/7iggyFPls4w','http://www.imdb.com/title/tt1019452/?ref_=nv_','aseriousman','2014-08-27 15:49:35'),(10,'Gravity','Dr. Ryan Stone (Sandra Bullock) is a brilliant medical engineer on her first shuttle mission, with veteran astronaut Matt Kowalsky (George Clooney) in command of his last flight before retiring. But on a seemingly routine spacewalk, disaster strikes. The shuttle is destroyed, leaving Stone and Kowalsky completely alone - tethered to nothing but each other and spiraling out into the blackness.','Alfonso Cuarón',2013,'5.99','gravityDVD.jpg','http://youtu.be/OiTiKOy59o4','http://www.imdb.com/title/tt1454468/?ref_=nv_','gravity','2014-08-28 11:33:01'),(11,'Y tu mamá también','In Mexico City, late teen friends Tenoch Iturbide and Julio Zapata are feeling restless as their respective girlfriends are traveling together through Europe before they all begin the next phase of their lives at college. At a lavish family wedding, Tenoch and Julio meet Luisa Cortés, the twenty-something wife of Tenoch\'s cousin Jano, the two who have just moved to Mexico from Spain. Tenoch and Julio try to impress the beautiful Luisa by telling her that they will be taking a trip to the most beautiful secluded beach in Mexico called la Boca del Cielo (translated to Heaven\'s Mouth), the trip and the beach which in reality don\'t exist. When Luisa learns of Jano\'s latest marital indiscretion straight from the horse\'s mouth, she takes Tenoch and Julio\'s offer to go along on this road trip, meaning that Tenoch and Julio have to pull together quickly a road trip to a non-existent beach. They decide to head toward one suggested by their friend Saba, who seems a little confused himself of this beach\'s location. On the road trip, which ends up not being totally harmonious, the three go on a trip of discovery. For Luisa, she has to figure out what to do with her immediate future based on the news from Jano and a secret she is keeping. And Tenoch and Julio have to figure out what their friendship really means as they grow up. ','Alfonso Cuarón',2001,'3.39','ytumamatambienDVD.jpg','http://youtu.be/3Qg6n7V3kO4','http://www.imdb.com/title/tt0245574/?ref_=nv_','tumama','2014-08-27 15:50:37'),(12,'Maleficent','A beautiful, pure-hearted young woman, Maleficent has an idyllic life growing up in a peaceable forest kingdom, until one day when an invading army threatens the harmony of the land. Maleficent rises to be the land\'s fiercest protector, but she ultimately suffers a ruthless betrayal - an act that begins to turn her pure heart to stone. Bent on revenge, Maleficent faces a battle with the invading king\'s successor and, as a result, places a curse upon his newborn infant Aurora. As the child grows, Maleficent realizes that Aurora holds the key to peace in the kingdom - and perhaps to Maleficent\'s true happiness as well. ','Robert Stromberg',2014,'5.99','maleficentDVD.jpg','http://youtu.be/w-XO4XiRop0','http://www.imdb.com/title/tt1587310/?ref_=nv_','maleficent','2014-08-27 15:48:28'),(13,'Her','Theodore is a lonely man in the final stages of his divorce. When he\'s not working as a letter writer, his down time is spent playing video games and occasionally hanging out with friends. He decides to purchase the new OS1, which is advertised as the world\'s first artificially intelligent operating system, \"It\'s not just an operating system, it\'s a consciousness,\" the ad states. Theodore quickly finds himself drawn in with Samantha, the voice behind his OS1. As they start spending time together they grow closer and closer and eventually find themselves in love. Having fallen in love with his OS, Theodore finds himself dealing with feelings of both great joy and doubt. As an OS, Samantha has powerful intelligence that she uses to help Theodore in ways others hadn\'t, but how does she help him deal with his inner conflict of being in love with an OS? ','Spike Jonze',2013,'4.39','herDVD.jpg','http://youtu.be/WzV6mXIOVl4','http://www.imdb.com/title/tt1798709/?ref_=fn_','her','2014-08-27 15:48:36'),(14,'Being John Malkovich','Craig, a puppeteer, takes a filing job in a low-ceilinged office in Manhattan. Although married to the slightly askew Lotte, he hits on a colleague, the sexually frank Maxine. She\'s bored but snaps awake when he finds a portal leading inside John Malkovich: for 15 minutes you see, hear, and feel whatever JM is doing, then you fall out by the New Jersey Turnpike. Maxine makes it commercial, selling trips for $200; also, she\'s more interested in Lotte than in Craig, but only when Lotte is inside JM. JM finds out what\'s going on and tries to stop it, but Craig sees the portal as his road to Maxine and to success as a puppeteer. Meanwhile, Lotte discovers others interested in the portal. ','Spike Jonze',1999,'2.99','beingjohnmalkovichDVD.jpg','http://youtu.be/K7ahIGLNNwo','http://www.imdb.com/title/tt0120601/?ref_=nv_','beingjohnmalkovich','2014-08-27 15:48:42');
/*!40000 ALTER TABLE `moviesRM` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movie2genreRM`
--

DROP TABLE IF EXISTS `movie2genreRM`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movie2genreRM` (
  `idMovie` int(11) NOT NULL,
  `idGenre` int(11) NOT NULL,
  PRIMARY KEY (`idMovie`,`idGenre`),
  KEY `idGenre` (`idGenre`),
  CONSTRAINT `movie2genreRM_ibfk_1` FOREIGN KEY (`idMovie`) REFERENCES `moviesRM` (`id`),
  CONSTRAINT `movie2genreRM_ibfk_2` FOREIGN KEY (`idGenre`) REFERENCES `genresRM` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movie2genreRM`
--

LOCK TABLES `movie2genreRM` WRITE;
/*!40000 ALTER TABLE `movie2genreRM` DISABLE KEYS */;
INSERT INTO `movie2genreRM` (`idMovie`, `idGenre`) VALUES (5,1),(11,1),(12,1),(13,1),(14,1),(9,2),(10,2),(11,2),(13,2),(14,2),(3,3),(4,3),(7,3),(8,3),(1,4),(2,4),(5,4),(11,4),(12,4),(1,6),(2,6),(4,6),(6,6),(9,6),(14,6),(5,7),(6,7),(12,7),(3,8),(4,8),(7,8),(8,8),(10,8),(10,9),(13,9);
/*!40000 ALTER TABLE `movie2genreRM` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table `userRM`
--

DROP TABLE IF EXISTS `userRM`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userRM` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acronym` char(12) NOT NULL,
  `name` varchar(80) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  `salt` int(11) NOT NULL,
  `info` text,
  `img` varchar(80) DEFAULT NULL,
  `authority` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `acronym` (`acronym`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userRM`
--

LOCK TABLES `userRM` WRITE;
/*!40000 ALTER TABLE `userRM` DISABLE KEYS */;
INSERT INTO `userRM` (`id`, `acronym`, `name`, `password`, `salt`, `info`, `img`, `authority`) VALUES (1,'doe','Jane Doe','7086ae6ca74bfeb2493492bdb2857138',1408189408,'I love movies and I am very happy to be a member at Rental Movies. My favourite films are Life Aquatic and The Darjeeling Limited. I love the films by Wes Anderson, the way he creates a beautiful world with original characters that make you forget about your boring job and the dishes, at least for some hours. ','user6.png','member'),(2,'admin','Administrator','8027ef33bd2487fc94e8a78ef722f9f6',1408189408,'I\'m the proud administrator of this page. Since I was a child I have always been inspired by the histories that movies tell us. So I really see it as a privilige to be able to work with films today. Here at Rental Movies we do our best to collect the movies that we think will inspire you in your daily life and make your friday nights a little bit better. In case you don\'t find your favourite movie in our catalogue, please dont hesitate to contact me - I will do my best to assure that you will always find the best and the latest films at Rental Movies.\r\n\r\n// The Administrator','user7.png','admin'),(7,'amanda','Amanda Marie Åberg','1ae942072ecb8b029e73c7cbe1b1eaa2',1409049150,'I\'m the girl who built this page for my school project. I really liked the task and found it fun to pick out some good movies and to put together a design for the webpage. I especially like to design the admin interface. It took me some while to decide how things should work together but I\'m quite satisfied with the results, although there\'s always room for improvement.','user5.png','admin'),(11,'peter','Peter Swanson','9783d73b5718a51f9794d74d66636393',1409316814,'Hi! I\'m Peter and I just got myself a membership here at Rental Movies. So far I think it seems to be a nice webpage and I have already found some films that I probably will rent for this weekend.','user3.png','member');
/*!40000 ALTER TABLE `userRM` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `vmovieRM`
--

DROP TABLE IF EXISTS `vmovieRM`;
/*!50001 DROP VIEW IF EXISTS `vmovieRM`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vmovieRM` (
  `id` tinyint NOT NULL,
  `title` tinyint NOT NULL,
  `info` tinyint NOT NULL,
  `director` tinyint NOT NULL,
  `year` tinyint NOT NULL,
  `price` tinyint NOT NULL,
  `img` tinyint NOT NULL,
  `trailer` tinyint NOT NULL,
  `link` tinyint NOT NULL,
  `imgfolder` tinyint NOT NULL,
  `lastedit` tinyint NOT NULL,
  `genre` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `vmovierm`
--

/*!50001 DROP TABLE IF EXISTS `vmovieRM`*/;
/*!50001 DROP VIEW IF EXISTS `vmovieRM`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vmovieRM` AS select `M`.`id` AS `id`,`M`.`title` AS `title`,`M`.`info` AS `info`,`M`.`director` AS `director`,`M`.`year` AS `year`,`M`.`price` AS `price`,`M`.`img` AS `img`,`M`.`trailer` AS `trailer`,`M`.`link` AS `link`,`M`.`imgfolder` AS `imgfolder`,`M`.`lastedit` AS `lastedit`,group_concat(`G`.`name` separator ',') AS `genre` from ((`moviesrm` `M` left join `movie2genrerm` `M2G` on((`M`.`id` = `M2G`.`idMovie`))) left join `genresrm` `G` on((`M2G`.`idGenre` = `G`.`id`))) group by `M`.`id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-08-31 10:27:20
