<?php
//le dictionnaire
$string = file_get_contents("dictionnaire.txt", FILE_USE_INCLUDE_PATH);
$tabDico = explode("\n", $string);

//exo 1
echo "Il y a: " . count($tabDico) . " mots dans le dictionnaire!<br>";

//exo 2
$word15 = 0;
$wordW = 0;
$wordQ = 0;
foreach ($tabDico as $word) {
    //mots à 15 lettres
    if(strlen(trim($word)) === 15) {
        $word15++;
    }
    //mots avec une lettre "w"
    if (strpos($word, "w")) {
        $wordW++;
    }
    //mots qui se terminent pas "q"
    if($word[strlen(trim($word)) - 1] === "q") {
        $wordQ++;
    }
}
echo "Il y a: " . $word15 . " mots dans le dictionnaire à 15 lettres!<br>";

echo "Il y a: " . $wordW . " mots dans le dictionnaire avec la lettre 'W'!<br>";

echo "Il y a: " . $wordQ . " mots dans le dictionnaire qui finnissent avec la lettre 'Q'!<br>";

echo "<br><br><br>";

//les films
$stringFilm = file_get_contents("films.json", FILE_USE_INCLUDE_PATH);
$films = json_decode($stringFilm, true);
$entry = $films['feed']['entry'];

//le top 10
for($x = 0; $x < 10; $x++) {
    echo ($x + 1) . ": " . $entry[$x]['im:name']['label'] . "<br>";
}
echo "<br>";

// Place du film "Gravity
$place = 0;
foreach ($entry as $film) {
    if($film['im:name']['label'] !== "Gravity") {
        $place++;
    }
    else {
        $place++;
        break;
    }
}
echo "Le film Gravity est à la: " . $place . " place du classement.<br>";

// Le réalisateur du film Lego
foreach ($entry as $film) {
    if($film['im:name']['label'] === "The LEGO Movie") {
        echo "Les réalisateurs du film 'The LEGO Movie' sont: " . $film["im:artist"]['label'] . ".<br>";
    }
}

// Le nombre de films réalisés avant 2000
$past2000 = 0;
foreach ($entry as $film) {
    if(strtotime($film['im:releaseDate']['label']) < strtotime("january 2, 2000")) {
        $past2000++;
    }
}
echo "Il y a " . $past2000 . " films qui ont été fait avant 2000 dans le classement.<br>";

// Le film le plus récent
$time = 0;
foreach ($entry as $film) {
    if(strtotime($film['im:releaseDate']['label']) > $time) {
        $time = strtotime($film['im:releaseDate']['label']);
    }
}

foreach ($entry as $film) {
    if(strtotime($film['im:releaseDate']['label']) === $time) {
        echo "Le film le plus récent est: " . $film['im:name']['label'] . " du " . $film['im:releaseDate']['attributes']['label'] .".<br>";
    }
}

// Le film le plus vieux
foreach ($entry as $film) {
    if(strtotime($film['im:releaseDate']['label']) < $time) {
        $time = strtotime($film['im:releaseDate']['label']);
    }
}

foreach ($entry as $film) {
    if(strtotime($film['im:releaseDate']['label']) === $time) {
        echo "Le film le plus vieux est: " . $film['im:name']['label'] . " du " . $film['im:releaseDate']['attributes']['label'] .".<br>";
    }
}

// La catégorie la plus présente
$category = [];
foreach ($entry as $film) {
    array_push($category, $film['category']['attributes']["label"]);
}

$categoryCount = array_count_values($category);
$maxCat = max($categoryCount);

foreach ($categoryCount as $item => $value) {
    if($value == $maxCat) {
        echo "La categorie la plus présente est: " . $item . ".<br>";
    }
}

// Le réalisateur le plus présent

$realisateur = [];
foreach ($entry as $film) {
    array_push($realisateur, trim($film['im:artist']['label']));
}

$realCount = array_count_values($realisateur);
$maxReal = max($realCount);

foreach ($realCount as $item => $value) {
    if($value == $maxReal) {
        echo "Le réalisateur le plus en vogue est: " . $item . ".<br>";
    }
}

// Acheter le top 10 et le louer

$sent = 0;
$rent = 0;

for($x = 0; $x < 10; $x++) {
    $sent = $sent + $entry[$x]['im:price']['attributes']['amount'];
    $rent += $entry[$x]['im:rentalPrice']['attributes']['amount'];
}
echo "Le prix d'achat pour le top 10 des films est de: " . $sent . " dollars <br>";
echo "Le prix de location pour le top 10 des films est de: " . $rent . " dollars <br>";

// Mois le plus de sortie

$months = [];
foreach ($entry as $film) {
    $month = strtotime($film['im:releaseDate']['attributes']['label']);
    array_push($months, strftime("%B", $month));
}

$monthsCount = array_count_values($months);
$maxMonth = max($monthsCount);

foreach ($monthsCount as $item => $value) {
    if($value == $maxMonth) {
        echo "La mois avec le plus de sortie est le mois de: " . $item . ".<br>";
    }
}
echo "<br><br>";

//Top 10 films budgets

$downPrices = [];
foreach ($entry as $film) {
    $downPrices[$film['im:name']['label']] = $film['im:price']['attributes']['amount'];
}

asort($downPrices);
$val = 0;

foreach ($downPrices as $item => $price) {
    if($val < 10) {
        echo ($val + 1) . ": " . $item . " à " . $price . " dollars <br>";
        $val++;
    }
}