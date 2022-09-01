<?php

namespace BenMajor\RedSeed;

use BenMajor\RedSeed\Exception\ArgumentException;
use RedBeanPHP\R;

class FunctionHandler
{
    private $chars = [ ];
    private $digits = [ ];

    private $_chars = 'abcdefghijklmnopqrstuvwxyz';
    private $_digits = '0123456789';

    public function __construct()
    {
        $this->chars = str_split($this->_chars);
        $this->digits = str_split($this->_digits);
    }

    /**
         * It takes two arguments, a minimum and maximum length, and returns a random string of characters
         * between those lengths
         *
         * @param array args An array of arguments passed to the function.
         *
         * @return A string of random characters.
         */
    public function string(array $args)
    {
        if (count($args) != 2) {
            throw new ArgumentException('string() expects exactly two arguments.');
        }

        $min = $args[0];
        $max = $args[1];

        if (!is_int($min) || !is_int($max)) {
            if ((!ctype_digit($min) || !ctype_digit($max))) {
                throw new ArgumentException('Both arguments specified for string() must be integers.');
            }
        }

        if ($min < 0) {
            throw new ArgumentException('Minimum length must be greater than 0.');
        }

        if ($max < 0) {
            throw new ArgumentException('Maximum length must be greater than 0.');
        }

        if ($max < $min) {
            throw new ArgumentException('Maximum length must be greater than or equal to minimum length');
        }

        $string = '';
        $length = rand($min, $max);

        for ($i = 0; $i < $length; $i++) {
            $string.= $this->chars[array_rand($this->chars)];
        }

        return $string;
    }

    /**
     * `word` returns a random word
     *
     * @param array args An array of arguments that can be passed to the generator.
     *
     * @return A string with the first letter capitalized.
     */
    public function word(array $args)
    {
        return ucfirst($this->string($args));
    }

    # Generate an integer of random length:
    public function integer(array $args)
    {
        if (count($args) != 2) {
            throw new ArgumentException('string() expects exactly two arguments.');
        }

        $min = $args[0];
        $max = $args[1];

        if (!is_int($min) || !is_int($max)) {
            if ((!ctype_digit($min) || !ctype_digit($max))) {
                throw new ArgumentException('Both arguments specified for string() must be integers.');
            }
        }

        if ($min < 0) {
            throw new ArgumentException('Minimum length must be greater than 0.');
        }

        if ($max < 0) {
            throw new ArgumentException('Maximum length must be greater than 0.');
        }

        if ($max < $min) {
            throw new ArgumentException('Maximum length must be greater than or equal to minimum length');
        }

        return mt_rand($min, $max);
    }

    # Return the current time:
    public function time(array $args)
    {
        return date('H:i:s');
    }

    # Return the current date:
    public function date(array $args)
    {
        return date('Y-m-d');
    }

    # Return the current datetime:
    public function datetime(array $args)
    {
        return R::isoDateTime();
    }

    # Generate a valid email address:
    public function email(array $args)
    {
        $mailnames = ['Zen','Misty','Lyra','Buffy','Leeloo','Zorg','Princess','Eloise','Jolene','MoKitty','Veronica','Sadie','Ozzie','Tabby','Nimbus','Kiki','Mickey','Haru','Sally','Stasia','Sweetheart','MrDarcy','Kali','Daisy','Ada','Rascal','Spider','Fog','AliciaKeys','Edom','Purcy','Mab','Guiness','Raspberry','Hank','Coco','Charlotte','Charlie','Katya','Frodo','Molly','Koshka','Eroteme','Ninotchka','Sofie','Catty','Maxx','Ruby','Ginger','Ralphie','Grace','Rosemary','Sammy','Sasha','Poonai','Seastar','Kip','Kato','Sven','Blackie','KitKat','Rolo','Eb','Arthur','Capri','Echo','Charlie','Hoshi','Horse','Marcello','Theo','Bradley','Mickey','Monster','TheMachine','Ariel','Ebby','Conway','Lavender','Otis','Olive','Gumbo','Ginger','Peaches','Velma','Phoebe','Cassiopeia','Tom','Diamond','Poppy','Theo','Eddy','Georgie','Mickey','Calcifer','Lilac','Shorbread','Anders','Malky','Maisy','Nermal','Bean','Madison','Coonzy','Tigre','Lionel','Batman','Smokey','Gaudi','Momo','Luigi','Nisha','Moshood','Charlie','Norah','Saehee','Spooky','Heidi','Lola','Gaius','KotBegemot','Calvin','Andy','Kurocho','Knut','Mrs.Peel','Lillie','Mouse','Tommie','Sunny','Sammy','Hagrid','Molly','Watermelon','Wintermelon','Montoya','Snickers','Liliquoi','Klaus','Bruno','Lucy','Juliet','Radar','SteelyDan','Kyle','Guinness','Hendricks','Bebot','Lusso','Leo','Riley','Angus','Max','LilMau','Kitten','Coco','Cezanne','Pepper','Ferbert','Evie','Simba','Sebastian','ZiZi','Brewster','Whatley','YoYoMao','Lily','Skip','Annie','Sophie','Fig','Mathilda','Chloe','Magenta','George','Simon','Fern','Octavia','Constantine','Nika','Hooch','Thursday','Frankie','Ziggy','Mason','Aggie','Shadow','Aguardiente','Moshi','Stanley','Tabatah','Maxwell','Michael','Omar','Rashid','Surya','Moose','Morpheus','Sherman','Mileva','Robby','Nikita','Gibby','Simon','Victoria','PuffPuff','BooBoo','Piper','Kanga','Lucy','Hodge','Gabe','MeiMei','Callie','Greg','Tuxie','Isis','Comet','Nebula','Violet','Skipper','Nala','Cali','Sophie','Leo','Calvin','Zinnia','Mackenzie','Oscar','Caesar','Mary','CC','Truffles','Taro','Willa','Rorschach','Zoot','Ella','Atti','Musubi','Paprika','Georgie','Orca','Gordon','Toshie','Bella','Lucky','Huey','Riddler','Miri','Clyde','Otis','Sam','Leroy','Wayne','Yuki','Luna','Barnaby','Korra','Phryne','Mittens','Sam','Peppermint','Abby','Elinor','Stella','RaulDiego','Oscar','Dali','Riley','Yoni','Diamond','Guwop','Elliot','Iris','Yuri','Ashton','Presta','Schrader','PuffAdder','Mamushi','Oliver','Elouise','Lily','Wallace','Luna','Senor','Raphael','Roo','Gus','Dynamo','Baloo','Boomer','Fox','Churchill','Clark','Lewis','Nacho','Galaxy','Kiya','Charlie','Blue','Louise','Moocher','Skoshi','Abby','Eckstein','Silvio','KatnissCatmanSimbaHoose','JinkxyHoose','Marshellow','MrStubbins','Ubud','Strider','Tipsy','Elliott','Cora','Bay','Hope','Sazerac','Marshall','JackBlack','Louie','Taj','Mitsy','Daphne','Molly','Frank','Ambrosia','Cupcake','Neah','Goose','James','Chip','Piano','Maverick','Moto','Hestia','Rex','Gatsby','Lucinda','La','Cleo','Athena','Maeve','Puck','Litten','Eddie','Ernie','Chickystarr','Mimi','Ella','FrancesBeans','Pai','Tom','Jake','Schatzi','Storm','JeanGrey','Shadow','Alto','SmollOne','Simon','George','Alice','Tonto','Zorro','Apollo','Leia','Oscar','Kyo','JohnnyCash','Ella','Frankie','Daisy','Selene','Apollo','Bandito','Ginny','Simba','Sapphire','Louie','Jeannie','Fufu','TinTin','Boots','OscarWorkman','Kitty','Lucy','JeanGray','Elizabeth','Spike','Dani','Luke','Moss','Mia','Gwendolyn','Morgan','Nina','Hitch','Barley','Hops','YammaJamma','CorkyLynn','Lucy','Stitches','Luna','River','Olive','Tesa','Bela','Ferrari','Annabella','Gracie','Harry','Loki','Princess','Twig','Colton','Scout','Maple','Momo','Lila','SweetPea','Hobbes','Stargazer','Tibia','Annabelle','Luna','Simon','Schmidt','Nick','Finn','Hermes','Merlin','Knute','Downey','Fiona','SashaFoo','Booboo','Casey','Betty','Steve','Tigger','Mocha','Totoro','Dublin','Kiara','Juniper','Julius','Nadia','Ori','Lucy','Ruby','Sophie','Zippy','Lily','Morris','Ridley','Josephine','Maisie','Misha','Mango','Julep','Gimlet','Mars','CaraCamille','Smudge','Wasabi','LittleMy','Jazzy','CaptainCathpurrine','Magnolia','Barnabus','Zardoz','Grayson','Murray','Christobel','Oz','LucyGeesesPotvin','Fig','Snuggles','Tuxy','Pounce','MrWizard','Roxie','Max','Ivan','Taz','Clementine','Winston','Katsu','Miso','Chris','Bumble','Benny','Bart','Lucy','Kevin','Clementine','Ginger','Lily','Danny','Tony'];


        $tlds = [ 'com', 'co.nz', 'de', 'info', 'org' ];

        $domains = [
            'gmail',
            'web',
            'aol',
            'posteo',
            'post',
            'mail',
            'gmx'
        ];

        # Build the email:
        return sprintf(
            '%s@%s.%s',
            $mailnames[array_rand($mailnames)],
            $domains[array_rand($domains)],
            $tlds[array_rand($tlds)]
        );
    }

    # Generate a random IP address:
    public function ipaddress(array $args)
    {
        return sprintf(
            '%d.%d.%d.%d',
            $this->integer([ 1, 255 ]),
            $this->integer([ 1, 255 ]),
            $this->integer([ 1, 255 ]),
            $this->integer([ 1, 255 ])
        );
    }

    public function lastnameDE(array $args)
    {
        $lastName = [ 'Ackermann', 'Adam', 'Adler', 'Ahrens', 'Albers', 'Albert', 'Albrecht', 'Altmann', 'Anders', 'Appel', 'Arndt', 'Arnold', 'Auer', 'Bach', 'Bachmann', 'Bader', 'Baier', 'Bartels', 'Barth', 'Barthel', 'Bartsch', 'Bauer', 'Baum', 'Baumann', 'Baumgartner', 'Baur', 'Bayer', 'Beck', 'Becker', 'Beckmann', 'Beer', 'Behrendt', 'Behrens', 'Beier', 'Bender', 'Benz', 'Berg', 'Berger', 'Bergmann', 'Berndt', 'Bernhardt', 'Bertram', 'Betz', 'Beyer', 'Binder', 'Bischoff', 'Bittner', 'Blank', 'Block', 'Blum', 'Bock', 'Bode', 'Born', 'Brand', 'Brandl', 'Brandt', 'Braun', 'Brenner', 'Breuer', 'Brinkmann', 'Brunner', 'Bruns', 'Brückner', 'Buchholz', 'Buck', 'Burger', 'Burkhardt', 'Busch', 'Busse', 'Bär', 'Böhm', 'Böhme', 'Böttcher', 'Bühler', 'Büttner', 'Christ', 'Conrad', 'Decker', 'Diehl', 'Dietrich', 'Dietz', 'Dittrich', 'Dorn', 'Döring', 'Dörr', 'Eberhardt', 'Ebert', 'Eckert', 'Eder', 'Ehlers', 'Eichhorn', 'Engel', 'Engelhardt', 'Engelmann', 'Erdmann', 'Ernst', 'Esser', 'Falk', 'Feldmann', 'Fiedler', 'Fink', 'Fischer', 'Fleischer', 'Fleischmann', 'Forster', 'Frank', 'Franke', 'Franz', 'Freitag', 'Freund', 'Frey', 'Fricke', 'Friedrich', 'Fritsch', 'Fritz', 'Fröhlich', 'Fuchs', 'Fuhrmann', 'Funk', 'Funke', 'Förster', 'Gabriel', 'Gebhardt', 'Geiger', 'Geisler', 'Geißler', 'Gerber', 'Gerlach', 'Geyer', 'Giese', 'Glaser', 'Gottschalk', 'Graf', 'Greiner', 'Grimm', 'Gross', 'Groß', 'Großmann', 'Gruber', 'Gärtner', 'Göbel', 'Götz', 'Günther', 'Haag', 'Haas', 'Haase', 'Hagen', 'Hahn', 'Hamann', 'Hammer', 'Hanke', 'Hansen', 'Harms', 'Hartmann', 'Hartung', 'Hartwig', 'Haupt', 'Hauser', 'Hecht', 'Heck', 'Heil', 'Heim', 'Hein', 'Heine', 'Heinemann', 'Heinrich', 'Heinz', 'Heinze', 'Held', 'Heller', 'Hempel', 'Henke', 'Henkel', 'Hennig', 'Henning', 'Hentschel', 'Herbst', 'Hermann', 'Herold', 'Herrmann', 'Herzog', 'Hess', 'Hesse', 'Heuer', 'Heß', 'Hildebrandt', 'Hiller', 'Hinz', 'Hirsch', 'Hoffmann', 'Hofmann', 'Hohmann', 'Holz', 'Hoppe', 'Horn', 'Huber', 'Hummel', 'Hübner', 'Jacob', 'Jacobs', 'Jahn', 'Jakob', 'Jansen', 'Janssen', 'Janßen', 'John', 'Jordan', 'Jost', 'Jung', 'Jäger', 'Jürgens', 'Kaiser', 'Karl', 'Kaufmann', 'Keil', 'Keller', 'Kellner', 'Kern', 'Kessler', 'Keßler', 'Kiefer', 'Kirchner', 'Kirsch', 'Klaus', 'Klein', 'Klemm', 'Klose', 'Kluge', 'Knoll', 'Koch', 'Kohl', 'Kolb', 'Konrad', 'Kopp', 'Kraft', 'Kramer', 'Kraus', 'Krause', 'Krauß', 'Krebs', 'Kremer', 'Kretschmer', 'Krieger', 'Kroll', 'Krug', 'Kruse', 'Krämer', 'Kröger', 'Krüger', 'Kuhlmann', 'Kuhn', 'Kunz', 'Kunze', 'Kurz', 'Köhler', 'König', 'Körner', 'Köster', 'Kühn', 'Kühne', 'Lang', 'Lange', 'Langer', 'Lauer', 'Lechner', 'Lehmann', 'Lemke', 'Lenz', 'Lindemann', 'Lindner', 'Link', 'Linke', 'Lohmann', 'Lorenz', 'Ludwig', 'Lutz', 'Löffler', 'Mack', 'Mai', 'Maier', 'Mann', 'Marquardt', 'Martens', 'Martin', 'Marx', 'Maurer', 'May', 'Mayer', 'Mayr', 'Meier', 'Meister', 'Meißner', 'Menzel', 'Merkel', 'Mertens', 'Merz', 'Metz', 'Metzger', 'Meyer', 'Michel', 'Michels', 'Miller', 'Mohr', 'Moll', 'Moritz', 'Moser', 'Möller', 'Müller', 'Münch', 'Nagel', 'Naumann', 'Neubauer', 'Neubert', 'Neuhaus', 'Neumann', 'Nickel', 'Niemann', 'Noack', 'Noll', 'Nolte', 'Nowak', 'Opitz', 'Oswald', 'Ott', 'Otto', 'Pape', 'Paul', 'Peter', 'Peters', 'Petersen', 'Pfeifer', 'Pfeiffer', 'Philipp', 'Pieper', 'Pietsch', 'Pohl', 'Popp', 'Preuß', 'Probst', 'Raab', 'Rapp', 'Rau', 'Rauch', 'Rausch', 'Reich', 'Reichel', 'Reichert', 'Reimann', 'Reimer', 'Reinhardt', 'Reiter', 'Renner', 'Reuter', 'Richter', 'Riedel', 'Riedl', 'Rieger', 'Ritter', 'Rohde', 'Rose', 'Roth', 'Rothe', 'Rudolph', 'Ruf', 'Runge', 'Rupp', 'Röder', 'Römer', 'Sander', 'Sauer', 'Sauter', 'Schade', 'Schaller', 'Scharf', 'Scheffler', 'Schenk', 'Scherer', 'Schiller', 'Schilling', 'Schindler', 'Schlegel', 'Schlüter', 'Schmid', 'Schmidt', 'Schmitt', 'Schmitz', 'Schneider', 'Scholz', 'Schott', 'Schrader', 'Schramm', 'Schreiber', 'Schreiner', 'Schröder', 'Schröter', 'Schubert', 'Schuler', 'Schulte', 'Schultz', 'Schulz', 'Schulze', 'Schumacher', 'Schumann', 'Schuster', 'Schwab', 'Schwarz', 'Schweizer', 'Schäfer', 'Schön', 'Schüler', 'Schütte', 'Schütz', 'Schütze', 'Seeger', 'Seidel', 'Seidl', 'Seifert', 'Seiler', 'Seitz', 'Siebert', 'Simon', 'Singer', 'Sommer', 'Sonntag', 'Springer', 'Stadler', 'Stahl', 'Stark', 'Steffen', 'Steffens', 'Stein', 'Steinbach', 'Steiner', 'Stephan', 'Stock', 'Stoll', 'Straub', 'Strauß', 'Strobel', 'Stumpf', 'Sturm', 'Thiel', 'Thiele', 'Thomas', 'Ullrich', 'Ulrich', 'Unger', 'Urban', 'Vetter', 'Vogel', 'Vogt', 'Voigt', 'Vollmer', 'Voss', 'Voß', 'Völker', 'Wagner', 'Wahl', 'Walter', 'Walther', 'Weber', 'Wegener', 'Wegner', 'Weidner', 'Weigel', 'Weis', 'Weise', 'Weiss', 'Weiß', 'Wendt', 'Wenzel', 'Werner', 'Westphal', 'Wetzel', 'Wiedemann', 'Wiegand', 'Wieland', 'Wiese', 'Wiesner', 'Wild', 'Wilhelm', 'Wilke', 'Will', 'Wimmer', 'Winkler', 'Winter', 'Wirth', 'Witt', 'Witte', 'Wittmann', 'Wolf', 'Wolff', 'Wolter', 'Wulf', 'Wunderlich', 'Zander', 'Zeller', 'Ziegler', 'Zimmer', 'Zimmermann', ];

        return $lastName[array_rand($lastName)];
    }



    public function nameDE(array $args)
    {
        $name = [ 'Achim', 'Adalbert', 'Adam', 'Adolf', 'Adrian', 'Ahmed', 'Ahmet', 'Albert', 'Albin', 'Albrecht', 'Alex', 'Alexander', 'Alfons', 'Alfred', 'Ali', 'Alois', 'Aloys', 'Alwin', 'Anatoli', 'Andre', 'Andreas', 'Andree', 'Andrej', 'Andrzej', 'André', 'Andy', 'Angelo', 'Ansgar', 'Anton', 'Antonio', 'Antonius', 'Armin', 'Arnd', 'Arndt', 'Arne', 'Arno', 'Arnold', 'Arnulf', 'Arthur', 'Artur', 'August', 'Axel', 'Bastian', 'Benedikt', 'Benjamin', 'Benno', 'Bernard', 'Bernd', 'Berndt', 'Bernhard', 'Bert', 'Berthold', 'Bertram', 'Björn', 'Bodo', 'Bogdan', 'Boris', 'Bruno', 'Burghard', 'Burkhard', 'Carl', 'Carlo', 'Carlos', 'Carsten', 'Christian', 'Christof', 'Christoph', 'Christopher', 'Christos', 'Claudio', 'Claus', 'Claus-Dieter', 'Claus-Peter', 'Clemens', 'Cornelius', 'Daniel', 'Danny', 'Darius', 'David', 'Denis', 'Dennis', 'Detlef', 'Detlev', 'Dierk', 'Dieter', 'Diethard', 'Diethelm', 'Dietmar', 'Dietrich', 'Dimitri', 'Dimitrios', 'Dirk', 'Domenico', 'Dominik', 'Eberhard', 'Eckard', 'Eckart', 'Eckehard', 'Eckhard', 'Eckhardt', 'Edgar', 'Edmund', 'Eduard', 'Edward', 'Edwin', 'Egbert', 'Egon', 'Ehrenfried', 'Ekkehard', 'Elmar', 'Emanuel', 'Emil', 'Engelbert', 'Enno', 'Enrico', 'Erhard', 'Eric', 'Erich', 'Erik', 'Ernst', 'Ernst-August', 'Erwin', 'Eugen', 'Ewald', 'Fabian', 'Falk', 'Falko', 'Felix', 'Ferdinand', 'Florian', 'Francesco', 'Franco', 'Frank', 'Franz', 'Franz Josef', 'Franz-Josef', 'Fred', 'Fredi', 'Fridolin', 'Friedbert', 'Friedemann', 'Frieder', 'Friedhelm', 'Friedrich', 'Friedrich-Wilhelm', 'Fritz', 'Gabriel', 'Gebhard', 'Georg', 'Georgios', 'Gerald', 'Gerd', 'Gerhard', 'Gernot', 'Gero', 'Gerold', 'Gert', 'Gilbert', 'Giovanni', 'Gisbert', 'Giuseppe', 'Gottfried', 'Gotthard', 'Gottlieb', 'Gregor', 'Guenter', 'Guido', 'Guiseppe', 'Gunnar', 'Gunter', 'Gunther', 'Gustav', 'Götz', 'Günter', 'Günther', 'Hagen', 'Halil', 'Hannes', 'Hanni', 'Hanno', 'Hanns', 'Hans', 'Hans Dieter', 'Hans Georg', 'Hans Jürgen', 'Hans Peter', 'Hans-Christian', 'Hans-Dieter', 'Hans-Georg', 'Hans-Gerd', 'Hans-Günter', 'Hans-Günther', 'Hans-Heinrich', 'Hans-Hermann', 'Hans-J.', 'Hans-Joachim', 'Hans-Jochen', 'Hans-Josef', 'Hans-Jörg', 'Hans-Jürgen', 'Hans-Martin', 'Hans-Otto', 'Hans-Peter', 'Hans-Ulrich', 'Hans-Walter', 'Hans-Werner', 'Hans-Wilhelm', 'Hansjörg', 'Hanspeter', 'Harald', 'Hardy', 'Harri', 'Harro', 'Harry', 'Hartmut', 'Hartwig', 'Hasan', 'Heiko', 'Heiner', 'Heino', 'Heinrich', 'Heinz', 'Heinz-Dieter', 'Heinz-Georg', 'Heinz-Günter', 'Heinz-Joachim', 'Heinz-Josef', 'Heinz-Jürgen', 'Heinz-Peter', 'Heinz-Werner', 'Helfried', 'Helge', 'Hellmut', 'Hellmuth', 'Helmar', 'Helmut', 'Helmuth', 'Hendrik', 'Henning', 'Henrik', 'Henry', 'Henryk', 'Herbert', 'Heribert', 'Hermann', 'Hermann-Josef', 'Herwig', 'Hilmar', 'Hinrich', 'Holger', 'Horst', 'Horst-Dieter', 'Hubert', 'Hubertus', 'Hugo', 'Hüseyin', 'Ibrahim', 'Ignaz', 'Igor', 'Ingo', 'Ingolf', 'Ismail', 'Ivan', 'Ivo', 'Jakob', 'Jan', 'Janusz', 'Jens', 'Jens-Uwe', 'Joachim', 'Jochen', 'Johann', 'Johannes', 'John', 'Jonas', 'Jonas', 'Jose', 'Josef', 'Joseph', 'Josip', 'Jost', 'Juergen', 'Julian', 'Julius', 'Juri', 'Jörg', 'Jörn', 'Jürgen', 'Kai-Uwe', 'Karl', 'Karl Heinz', 'Karl-Ernst', 'Karl-Friedrich', 'Karl-Heinrich', 'Karl-Heinz', 'Karl-Josef', 'Karl-Ludwig', 'Karl-Otto', 'Karl-Wilhelm', 'Karlheinz', 'Karsten', 'Kaspar', 'Kevin', 'Klaus', 'Klaus Dieter', 'Klaus Peter', 'Klaus-Dieter', 'Klaus-Jürgen', 'Klaus-Peter', 'Klemens', 'Knut', 'Konrad', 'Konstantin', 'Konstantinos', 'Kuno', 'Kurt', 'Lars', 'Leo', 'Leonhard', 'Leonid', 'Leopold', 'Lorenz', 'Lothar', 'Ludger', 'Ludwig', 'Luigi', 'Lukas', 'Lutz', 'Magnus', 'Maik', 'Malte', 'Manfred', 'Manuel', 'Marc', 'Marcel', 'Marco', 'Marcus', 'Marek', 'Marian', 'Mario', 'Marius', 'Mark', 'Marko', 'Markus', 'Martin', 'Mathias', 'Matthias', 'Max', 'Maximilian', 'Mehmet', 'Meinhard', 'Meinolf', 'Metin', 'Michael', 'Michel', 'Mike', 'Milan', 'Mirco', 'Mirko', 'Miroslav', 'Miroslaw', 'Mohamed', 'Moritz', 'Murat', 'Mustafa', 'Nico', 'Nicolas', 'Niels', 'Nikola', 'Nikolai', 'Nikolaj', 'Nikolaos', 'Nikolaus', 'Nils', 'Norbert', 'Norman', 'Olaf', 'Oliver', 'Ortwin', 'Oskar', 'Osman', 'Oswald', 'Otmar', 'Ottmar', 'Otto', 'Pascal', 'Patrick', 'Paul', 'Peer', 'Peter', 'Philip', 'Philipp', 'Pierre', 'Pietro', 'Piotr', 'Rafael', 'Raimund', 'Rainer', 'Ralf', 'Ralph', 'Ramazan', 'Raphael', 'Reimund', 'Reiner', 'Reinhard', 'Reinhardt', 'Reinhold', 'Rene', 'René', 'Richard', 'Rico', 'Robert', 'Roberto', 'Robin', 'Roger', 'Roland', 'Rolf', 'Rolf-Dieter', 'Roman', 'Ronald', 'Ronny', 'Rudi', 'Rudolf', 'Rupert', 'Rüdiger', 'Salvatore', 'Samuel', 'Sandro', 'Sebastian', 'Sergej', 'Siegbert', 'Siegfried', 'Siegmar', 'Siegmund', 'Sigmund', 'Sigurd', 'Silvio', 'Simon', 'Stanislaw', 'Stefan', 'Steffen', 'Stephan', 'Steven', 'Sven', 'Swen', 'Sönke', 'Sören', 'Theo', 'Theodor', 'Thilo', 'Thomas', 'Thorsten', 'Till', 'Tilo', 'Tim', 'Timo', 'Tino', 'Tobias', 'Tom', 'Toni', 'Torben', 'Torsten', 'Udo', 'Ulf', 'Uli', 'Ullrich', 'Ulrich', 'Uwe', 'Valentin', 'Veit', 'Victor', 'Viktor', 'Vincenzo', 'Vinzenz', 'Vitali', 'Vladimir', 'Volker', 'Volkmar', 'Waldemar', 'Walter', 'Walther', 'Wenzel', 'Werner', 'Wieland', 'Wilfried', 'Wilhelm', 'Willi', 'William', 'Willibald', 'Willy', 'Winfried', 'Wladimir', 'Wolf', 'Wolf-Dieter', 'Wolfgang', 'Wolfram', 'Wulf', 'Xaver', 'Yusuf', 'Adele', 'Adelheid', 'Agathe', 'Agnes', 'Alexandra', 'Alice', 'Alma', 'Almut', 'Aloisia', 'Alwine', 'Amalie', 'Ana', 'Anastasia', 'Andrea', 'Anett', 'Anette', 'Angela', 'Angelika', 'Anika', 'Anita', 'Anja', 'Anke', 'Anna', 'Anna-Maria', 'Anne', 'Annegret', 'Annelie', 'Annelies', 'Anneliese', 'Annelore', 'Annemarie', 'Annerose', 'Annett', 'Annette', 'Anni', 'Annika', 'Anny', 'Antje', 'Antonia', 'Antonie', 'Ariane', 'Astrid', 'Auguste', 'Ayse', 'Babette', 'Barbara', 'Beate', 'Beatrice', 'Beatrix', 'Bernadette', 'Berta', 'Bettina', 'Betty', 'Bianca', 'Bianka', 'Birgit', 'Birgitt', 'Birgitta', 'Birte', 'Brigitta', 'Brigitte', 'Britta', 'Brunhild', 'Brunhilde', 'Bärbel', 'Carina', 'Carla', 'Carmen', 'Carola', 'Carolin', 'Caroline', 'Cathrin', 'Catrin', 'Centa', 'Charlotte', 'Christa', 'Christel', 'Christiane', 'Christin', 'Christina', 'Christine', 'Christl', 'Cindy', 'Claudia', 'Conny', 'Constanze', 'Cordula', 'Corina', 'Corinna', 'Cornelia', 'Cäcilia', 'Cäcilie', 'Dagmar', 'Dana', 'Daniela', 'Danuta', 'Denise', 'Diana', 'Dietlinde', 'Dora', 'Doreen', 'Doris', 'Dorit', 'Dorothea', 'Dorothee', 'Dunja', 'Dörte', 'Edda', 'Edelgard', 'Edeltraud', 'Edeltraut', 'Edith', 'Elena', 'Eleonore', 'Elfi', 'Elfriede', 'Elisabeth', 'Elise', 'Elke', 'Ella', 'Ellen', 'Elli', 'Elly', 'Elsa', 'Elsbeth', 'Else', 'Elvira', 'Emilia', 'Emilie', 'Emine', 'Emma', 'Emmi', 'Emmy', 'Erika', 'Erna', 'Ernestine', 'Esther', 'Eugenie', 'Eva', 'Eva-Maria', 'Evelin', 'Eveline', 'Evelyn', 'Evelyne', 'Evi', 'Ewa', 'Fatma', 'Felicitas', 'Franziska', 'Frauke', 'Frida', 'Frieda', 'Friederike', 'Gabi', 'Gabriela', 'Gabriele', 'Gaby', 'Galina', 'Gerda', 'Gerhild', 'Gerlinde', 'Gerta', 'Gerti', 'Gertraud', 'Gertraude', 'Gertrud', 'Gertrude', 'Gesa', 'Gesine', 'Giesela', 'Gisela', 'Gitta', 'Grete', 'Gretel', 'Grit', 'Gudrun', 'Gunda', 'Gundula', 'Halina', 'Hanna', 'Hanne', 'Hannelore', 'Hatice', 'Hedi', 'Hedwig', 'Heide', 'Heidemarie', 'Heiderose', 'Heidi', 'Heidrun', 'Heike', 'Helen', 'Helena', 'Helene', 'Helga', 'Hella', 'Helma', 'Henny', 'Henri', 'Henriette', 'Hermine', 'Herta', 'Hertha', 'Hilda', 'Hilde', 'Hildegard', 'Hiltrud', 'Ida', 'Ilka', 'Ilona', 'Ilse', 'Imke', 'Ina', 'Ines', 'Inga', 'Inge', 'Ingeborg', 'Ingeburg', 'Ingelore', 'Ingrid', 'Inka', 'Inna', 'Irena', 'Irene', 'Irina', 'Iris', 'Irma', 'Irmgard', 'Irmhild', 'Irmtraud', 'Irmtraut', 'Isa', 'Isabel', 'Isabell', 'Isabella', 'Isabelle', 'Isolde', 'Ivonne', 'Jacqueline', 'Jana', 'Janet', 'Janina', 'Janine', 'Jaqueline', 'Jasmin', 'Jeanette', 'Jeannette', 'Jennifer', 'Jenny', 'Jessica', 'Joanna', 'Johanna', 'Johanne', 'Jolanta', 'Josefa', 'Josefine', 'Judith', 'Julia', 'Juliane', 'Jutta', 'Karen', 'Karin', 'Karina', 'Karla', 'Karola', 'Karolina', 'Karoline', 'Katarina', 'Katharina', 'Kathleen', 'Kathrin', 'Kati', 'Katja', 'Katrin', 'Kerstin', 'Kirsten', 'Kirstin', 'Klara', 'Klaudia', 'Konstanze', 'Kornelia', 'Kristin', 'Kristina', 'Krystyna', 'Kunigunde', 'Käte', 'Käthe', 'Larissa', 'Laura', 'Lena', 'Leni', 'Leonore', 'Liane', 'Lidia', 'Liesbeth', 'Liesel', 'Lieselotte', 'Lilli', 'Lilly', 'Lilo', 'Lina', 'Linda', 'Lisa', 'Lisbeth', 'Liselotte', 'Loni', 'Lore', 'Lotte', 'Lucia', 'Lucie', 'Ludmila', 'Ludmilla', 'Luise', 'Luzia', 'Luzie', 'Lydia', 'Madeleine', 'Magda', 'Magdalena', 'Magdalene', 'Maike', 'Maja', 'Mandy', 'Manja', 'Manuela', 'Mareike', 'Maren', 'Marga', 'Margareta', 'Margarete', 'Margaretha', 'Margarethe', 'Margarita', 'Margit', 'Margitta', 'Margot', 'Margret', 'Margrit', 'Maria', 'Marianne', 'Marie', 'Marie-Luise', 'Marietta', 'Marija', 'Marika', 'Marina', 'Marion', 'Marita', 'Maritta', 'Marlen', 'Marlene', 'Marlies', 'Marliese', 'Marlis', 'Marta', 'Martha', 'Martina', 'Mathilde', 'Mechthild', 'Meike', 'Melanie', 'Melitta', 'Meta', 'Michaela', 'Mina', 'Minna', 'Miriam', 'Mirjam', 'Mona', 'Monica', 'Monika', 'Monique', 'Nadine', 'Nadja', 'Nancy', 'Natalia', 'Natalie', 'Natalja', 'Natascha', 'Nathalie', 'Nelli', 'Nicole', 'Nina', 'Nora', 'Olga', 'Ortrud', 'Ottilie', 'Pamela', 'Patricia', 'Patrizia', 'Paula', 'Pauline', 'Peggy', 'Petra', 'Pia', 'Ramona', 'Rebecca', 'Regina', 'Regine', 'Reinhild', 'Reinhilde', 'Renata', 'Renate', 'Resi', 'Ria', 'Ricarda', 'Rita', 'Romy', 'Rosa', 'Rosalinde', 'Rose', 'Rosel', 'Rosemarie', 'Rosi', 'Rosina', 'Rosita', 'Rosmarie', 'Roswitha', 'Ruth', 'Sabina', 'Sabine', 'Sabrina', 'Sandra', 'Sandy', 'Sara', 'Sarah', 'Saskia', 'Selma', 'Sibylle', 'Sieglinde', 'Siegrid', 'Siglinde', 'Sigrid', 'Sigrun', 'Silke', 'Silvana', 'Silvia', 'Simona', 'Simone', 'Sina', 'Sofia', 'Sofie', 'Sonja', 'Sophia', 'Sophie', 'Stefanie', 'Steffi', 'Stephanie', 'Susan', 'Susann', 'Susanna', 'Susanne', 'Svenja', 'Svetlana', 'Swetlana', 'Sybille', 'Sylke', 'Sylvia', 'Tamara', 'Tanja', 'Tatjana', 'Teresa', 'Thea', 'Thekla', 'Theresa', 'Therese', 'Theresia', 'Tina', 'Traudel', 'Traute', 'Trude', 'Ulla', 'Ulrike', 'Ursel', 'Ursula', 'Uschi', 'Uta', 'Ute', 'Valentina', 'Valeri', 'Valerie', 'Vanessa', 'Vera', 'Verena', 'Veronika', 'Viktoria', 'Viola', 'Walburga', 'Wally', 'Waltraud', 'Waltraut', 'Wanda', 'Wendelin', 'Wera', 'Wiebke', 'Wilhelmine', 'Wilma', 'Wiltrud', 'Yvonne', 'Änne', ];

        return $name[array_rand($name)];
    }




    public function city(array $args)
    {
        $city = ['Aachen','Aalen','Amberg','Annaberg-Buchholz','Ansbach','Aschaffenburg','Auerbach/Vogtland','Augsburg','Bad Kreuznach','Baden-Baden','Bamberg','Baunatal','Bautzen','Bayreuth','Berlin','Bernau bei Berlin','Biberach an der Riß','Bielefeld','Bocholt','Bochum','Bonn','Bottrop','Brandenburg an der Havel','Braunschweig','Bremen','Bremerhaven','Castrop-Rauxel','Celle','Chemnitz','Coburg','Cottbus','Darmstadt','Delitzsch','Delmenhorst','Dessau-Roßlau','Dortmund','Dresden','Duisburg','Düren','Düsseldorf','Eberswalde','Eisenach','Eisenhüttenstadt','Emden','Erfurt','Erkner','Erlangen','Essen','Esslingen am Neckar','Falkensee','Flensburg','Forst (Lausitz)','Frankenthal (Pfalz)','Frankfurt (Oder)','Frankfurt am Main','Freiberg','Freiburg im Breisgau','Friedrichshafen','Fulda','Fürth','Gelsenkirchen','Gera','Gießen','Gladbeck','Glauchau','Goslar','Gotha','Greifswald','Gräfelfing','Göttingen','Gütersloh','Hagen','Halberstadt','Halle (Saale)','Hamburg','Hameln','Hamm','Hanau','Hannover','Heidelberg','Heidenheim an der Brenz','Heilbronn','Hennigsdorf','Herford','Herne','Hildesheim','Hof','Hoyerswerda','Ingolstadt','Iserlohn','Jena','Kaiserslautern','Kamenz','Karlsruhe','Kassel','Kaufbeuren','Kempten (Allgäu)','Kiel','Koblenz','Konstanz','Krefeld','Köln','Landau in der Pfalz','Landsberg am Lech','Landshut','Leipzig','Leverkusen','Limbach-Oberfrohna','Lindau (Bodensee)','Ludwigsburg','Ludwigshafen am Rhein','Lörrach','Lübeck','Lüneburg','Magdeburg','Mainz','Mannheim','Marburg','Memmingen','Mönchengladbach','Mühlhausen/Thüringen','Mülheim an der Ruhr','München','Münster','Neu-Ulm','Neubrandenburg','Neuenhagen bei Berlin','Neumünster','Neuruppin','Neuss','Neustadt am Rübenberge','Neustadt an der Weinstraße','Neustadt bei Coburg','Neuwied','Nordhausen','Nürnberg','Oberhausen','Offenbach am Main','Offenburg','Oldenburg','Oranienburg','Osnabrück','Passau','Pforzheim','Pirmasens','Pirna','Plauen','Potsdam','Quedlinburg','Recklinghausen','Regensburg','Remscheid','Reutlingen','Riesa','Rosenheim','Rostock','Saarbrücken','Salzgitter','Sassnitz','Schwabach','Schwedt/Oder','Schweinfurt','Schwerin','Schwäbisch Gmünd','Siegen','Sindelfingen','Solingen','Speyer','Stendal','Straubing','Stuttgart','Suhl','Taucha','Teltow','Teterow','Trier','Tübingen','Ulm','Velten','Viersen','Villingen-Schwenningen','Weiden in der Oberpfalz','Weimar','Wiesbaden','Wilhelmshaven','Wismar','Witten','Wittenberg','Wolfsburg','Wolgast','Worms','Wuppertal','Würzburg','Zweibrücken','Zwickau' ];

        return $city[array_rand($city)];
    }





    public function street(array $args)
    {
        $streets = ['Hauptstraße','Bahnhofstraße','Schulstraße','Dorfstraße','Gartenstraße','Bergstraße','Kirchstraße','Lindenstraße','Birkenweg','Schillerstraße','Goethestraße','Waldstraße','Ringstraße','Jahnstraße','Amselweg','Wiesenstraße','Buchenweg','Mozartstraße','Rosenstraße','Blumenstraße','Ahornweg','Finkenweg','Feldstraße','Beethovenstraße','Industriestraße','Mühlenstraße','Bachstraße','Eichenweg','Friedhofstraße','Wiesenweg','Erlenweg','Talstraße','Poststraße','Uhlandstraße','AmSportplatz','Kirchplatz','Marktplatz','Raiffeisenstraße','Brunnenstraße','Lessingstraße','BreslauerStraße','Drosselweg','Schloßstraße','BerlinerStraße','Lindenweg','Tannenweg','Burgstraße','Mühlenweg','Lerchenweg','KönigsbergerStraße','Rosenweg','Mittelstraße','Fliederweg','Parkstraße','DanzigerStraße','Wilhelmstraße','Meisenweg','Schützenstraße','Marktstraße','Friedrichstraße','Kirchweg','AmBahnhof','Kiefernweg','Fasanenweg','Römerstraße','NeueStraße','Birkenstraße','Schubertstraße','Kirchgasse','Marienstraße','Karlstraße','Tulpenweg','Eichendorffstraße','Kastanienweg','Gartenweg','LangeStraße','GrünerWeg','StettinerStraße','Friedrich-Ebert-Straße','Schulweg','Eschenweg','ImWinkel','Nelkenweg','Markt','Waldweg','Nordstraße','Rathausstraße','Ulmenweg','Pestalozzistraße','Sudetenstraße','Brückenstraße','Gutenbergstraße','Kolpingstraße','Kantstraße','Seestraße','Kapellenweg','Robert-Koch-Straße','Mühlweg','Bismarckstraße','Richard-Wagner-Straße','Schwalbenweg','KurzeStraße','Ginsterweg','Fichtenweg','Ahornstraße','Eichenstraße','Zeppelinstraße','Kreuzstraße','Steinstraße','Friedensstraße','Heideweg','Südstraße','Mörikestraße','Mühlstraße','Friedenstraße','Holunderweg','Heinrich-Heine-Straße','AmHang','Albert-Schweitzer-Straße','Buchenstraße','Siemensstraße','Akazienweg','Hölderlinstraße','Kapellenstraße','AmAnger','Gerhart-Hauptmann-Straße','Mittelweg','Lärchenweg','Sonnenstraße','Steinweg','Pappelweg','Klosterstraße','Haydnstraße','Nelkenstraße','Starenweg','Ludwigstraße','LeipzigerStraße','August-Bebel-Straße','Daimlerstraße','Tulpenstraße','Asternweg','Flurstraße','Rathausplatz','AmMarkt','Geschwister-Scholl-Straße','Weinbergstraße','Grabenstraße','Rheinstraße','Jägerstraße','Falkenweg','Hochstraße','Oststraße','Weidenweg','Dahlienweg','Robert-Bosch-Straße','Höhenweg','Frankenstraße','Querstraße','Schlehenweg','Dieselstraße','Silcherstraße','Sonnenweg','Lerchenstraße','Teichstraße','Max-Planck-Straße','Pfarrgasse','Veilchenweg','Händelstraße','Luisenstraße','Röntgenstraße','Humboldtstraße','Wacholderweg','Forststraße','Martin-Luther-Straße','NeuerWeg','Weststraße','BreiteStraße','Sandweg','AlteDorfstraße','Theodor-Heuss-Straße','Ulmenstraße','Rotdornweg','ImWiesengrund','Herderstraße','Lilienweg','Brahmsstraße','Fichtenstraße','Hermann-Löns-Straße','HoheStraße','Karl-Marx-Straße','Hindenburgstraße','Brunnenweg','Blumenweg','Gewerbestraße','Erlenstraße','Fliederstraße','Heckenweg','Dammstraße','Lindenallee'];

        return $streets[array_rand($streets)];
    }





    public function bodyparts(array $args)
    {
        $bodyparts = ['ear', 'chin', 'neck', 'chest', 'right arm', 'left arm', 'left hand', 'right hand', 'right leg', 'left leg', 'left foot', 'right foot', 'toes', 'left ankle', 'right ankle', 'navel', 'left shoulder', 'right shoulder', 'left elbow', 'right elbow', 'back'];

        return $bodyparts[array_rand($bodyparts)];
    }









    public function color(array $args)
    {
        $colors = ['#c19c90', ' #2798e4', ' #988cca', ' #c9ac57', ' #cb7832', ' #e9553b', ' #6a8759', '#DFFF00', '#FFBF00', '#FF7F50', '#DE3163', '#9FE2BF', '#40E0D0', '#6495ED', '#9E5FFF', '#CCCCFF', '#90EE90', '#AFE1AF', '#A95C68', '#E5AA70', '#87CEEB'];

        return $colors[array_rand($colors)];
    }









    public function lorem(array $args)
    {
        $lorem = ["lorem", "ipsum", "dolor", "sit", "amet", "consectetur", "adipiscing", "elit", "praesent", "interdum", "dictum", "mi", "non", "egestas", "nulla", "in", "lacus", "sed", "sapien", "placerat", "malesuada", "at", "erat", "etiam", "id", "velit", "finibus", "viverra", "maecenas", "mattis", "volutpat", "justo", "vitae", "vestibulum", "metus", "lobortis", "mauris", "luctus", "leo", "feugiat", "nibh", "tincidunt", "a", "integer", "facilisis", "lacinia", "ligula", "ac", "suspendisse", "eleifend", "nunc", "nec", "pulvinar", "quisque", "ut", "semper", "auctor", "tortor", "mollis", "est", "tempor", "scelerisque", "venenatis", "quis", "ultrices", "tellus", "nisi", "phasellus", "aliquam", "molestie", "purus", "convallis", "cursus", "ex", "massa", "fusce", "felis", "fringilla", "faucibus", "varius", "ante", "primis", "orci", "et", "posuere", "cubilia", "curae", "proin", "ultricies", "hendrerit", "ornare", "augue", "pharetra", "dapibus", "nullam", "sollicitudin", "euismod", "eget", "pretium", "vulputate", "urna", "arcu", "porttitor", "quam", "condimentum", "consequat", "tempus", "hac", "habitasse", "platea", "dictumst", "sagittis", "gravida", "eu", "commodo", "dui", "lectus", "vivamus", "libero", "vel", "maximus", "pellentesque", "efficitur", "class", "aptent", "taciti", "sociosqu", "ad", "litora", "torquent", "per", "conubia", "nostra", "inceptos", "himenaeos", "fermentum", "turpis", "donec", "magna", "porta", "enim", "curabitur", "odio", "rhoncus", "blandit", "potenti", "sodales", "accumsan", "congue", "neque", "duis", "bibendum", "laoreet", "elementum", "suscipit", "diam", "vehicula", "eros", "nam", "imperdiet", "sem", "ullamcorper", "dignissim", "risus", "aliquet", "habitant", "morbi", "tristique", "senectus", "netus", "fames", "nisl", "iaculis", "cras", "aenean"];
        $text = "";
        for ($s = 0; $s < $args[0]; ++$s) {
            $text .= $lorem[array_rand($lorem)].' ';
        }

        return $text;
    }
}