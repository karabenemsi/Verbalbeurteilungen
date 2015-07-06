<?php

//How do you want to call this site?

$siteheading='Verbalbeurteilungen';

// The Server your database is hosted on. Normal value is 'localhost'
$databasehost="localhost";
// The username to log into your database.
$databaseusername="root";
// The password for your database
$databasepassword="root";
// The name of your database. Default is 'verbalbeurteilungen'
$databasename="verbalbeurteilungen";

// The names of the subjects. Please add new ones in the following syntax:
//
//         'english',   Dont forget the ','!!
//         'math'       Last one gets no comma !!
//          );

$SUBJECTS = array(
    'Deutsch',          //0
    'Mathematik',       //1
    'Englisch',         //2
    'Biologie',         //3
    'Physik',           //4
    'Geschichte',       //5
    'Erdkunde',         //6
    'Sport',            //7
    'Kunst',            //8
    'Musik',            //9
    'Religion',         //10 <- 'subreligion' down there
    'Naturphaenomene',  //11
    'Pool'              //12
);

//Are there different kinds on religon? Add them here. Syntax is:
//         'religion1' => 'evangelisch',    Dont forget the ','!!
//         'religion2' => 'katholisch',
//         'religion3' => 'ethik'           Last one gets no comma !!

$RELIGION = array(
    'subreligion' => 10, // !!Don't use '' in this case!! Which subject is religion in the list above? In the default/demo it's 11. If you got no subject religion set it to 0;
    'religion1' => 'katholisch',
    'religion2' => 'evangelisch',
    'religion3' => 'ethik'
);

//The categories you want to rate your students. If you want to add,remove or manipulate please use the following pattern:
//
//      array(
//          'Title of category',
//              'gradation number 1',
//              'gradation number2',
//              'gradation number3',
//              ...
//              'gradation numberN'
//            ),
//
//If you want to add someting remember: the last category gets no comma at the end, the rest deserves on.

$CATEGORIES = array(
    array(
        'Lernbereitschaft',
            'lernte mit besonderem Interesse und Flei&szlig;',
            'lernte interessiert und flei&szlig;ig',
            'war nicht immer interessiert und lernwillig',
            'zeigte oft wenig Interesse'
        ),
    array(
        'Aufmerksamkeit und Ausdauer',
            'arbeitete sehr aufmerksam und ausdauernd',
            'arbeitete aufmerksam',
            'arbeitete nicht gleich bleibend aufmerksam',
            'war h$auml;fig unaufmerksam'
        ),
    array(
        'Beteiligung am Unterrricht',
            'beteiligte sich regelm&auml;&szlig;ig mit guten Beitr&auml;gen',
            'beteiligte sich regelm&auml;&szlig;ig',
            'beteiligte sich gelegentlich',
            'beteiligte sich selten'
        ),
    array(
        'Hausaufgaben',
            'erledigte die Hausaufgaben sorgf&auml;ltig und zuverl&auml;ssig',
            'erledigte die Hausaufgaben nicht immer sorgf&auml;ltig und zuverl&auml;ssig',
            'erledigte die Hausaufgaben meist nachl&auml;ssig',
            'erledigte die Hausaufgaben oft nicht'
        ),
    array(
        'Selbstst&auml;ndigkeit',
            'arbeitete sehr selbstst&auml;ndig',
            'arbeitete selbst&auml;ndig',
            'hatte zuweilen Schwierigkeiten, Aufgaben selbst zu erledigen',
            'konnte kaum selbst&auml;ndig arbeiten und ben&ouml;tigte meist Hilfe'
        ),
    array(
        'Teamf&auml;higkeit',
            'arbeitete stets mit anderen zielgerichtet und sehr gut zusammen',
            'arbeitete gerne und gut in der Gruppe',
            'arbeitete h&auml;ufig ohne eigene Beitr&auml;ge in der Gruppe mit',
            'tat sich h&auml;ufig schwer bei der Zusammenarbeit'
        ),
    array(
        'Einhalten von Regeln',
            'hielt die Regeln ein',
            'hatte Probleme mit dem Einhalten von Regeln'
        ),
    array(
        'Einsatz f&uuml;r das Klassenklima',
            'setzte sich sehr aktiv f&uuml;r die Klassengemeinschaft ein',
            'war h&auml;ufig bereit zu helfen und/oder Streit zu schlichten',
            'lie&szlig; gelegentlich R&uuml;cksichtnahme vermissen',
            'lie&szlig; h&auml;ufig R&uuml;cksichtnahme vermissen'
        ) //!last one gets no comma
    );




// The rest of this file is nothing interesting, nothing to configure, you are done

//

//

//


//Declare variables as constats to use them global;
define('DATABASE_HOST', $databasehost);
define('DATABASE_USERNAME', $databaseusername);
define('DATABASE_PASSWORD', $databasepassword);
define('DATABASE_NAME', $databasename);
define('SITEHEADING', $siteheading);
?>
