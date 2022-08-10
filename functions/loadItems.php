<?php
/*
$jsonFile: place of the json file
$imagesFolder: place of the ../images files
$isLink: are the items links or just ../images
$lang: language, either ar or en
*/
function loadItems($jsonFile, $lang, $root = "../../") {
    $jsonFile = $root . "arrays/" . $jsonFile;
    $items = json_decode(file_get_contents($jsonFile), true);
    $extraItems = count(array_slice($items, floor(count($items) - (count($items) % 3))));
    for ($i = 0; $i < floor(count($items) / 3); $i++) {
        for ($c = 0; $c < 3; $c++) {
            if ($c == 0) {
                echo "<tr>";
            }
            $rowspan = (int) ($c == 1 && $i == floor(count($items) / 3) - 1 && $extraItems == 2) + 1; 
            $hasTitle = isset($items[$i * 3 + $c]["hasTitle"]) ? $items[$i * 3 + $c]["hasTitle"] : false;
            $desc = isset($items[$i * 3 + $c][$lang . "Description"]) ? $items[$i * 3 + $c][$lang . "Description"] : false;
            $link = isset($items[$i * 3 + $c]["href"]) ? $items[$i * 3 + $c]["href"] : false;
            echo "<td rowspan='" . $rowspan . "'>";
            echo $hasTitle  ? "<div><h3>" . htmlspecialchars($items[$i * 3 + $c][$lang . "Name"]) . "</h3>" : "";
            echo $desc ? "<figure>" : "";
            echo $link ? "<a class='image-cont' href='" . htmlspecialchars($link) . "'>" : "<div class='image-cont'>";
            echo "<img src='" . $root . "images/" . (isset($items[$i * 3 + $c][$lang . "Picture"]) ? htmlspecialchars($items[$i * 3 + $c][$lang . "Picture"]) : htmlspecialchars($items[$i * 3 + $c]["picture"])) . "' alt ='" . htmlspecialchars($items[$i * 3 + $c][$lang . "Name"]) . "'/>";
            echo $link ? "</a>" : "</div>";
            echo $desc ? "<figcaption>" . htmlspecialchars($desc) . "</figcaption></figure>" : "";
            echo $hasTitle ? "</div>" : "";
            echo "</td>";
            if ($c == 2) {
                echo "</tr>";
            }
        }
    }
    switch ($extraItems) {
        case 1:
            $hasTitle = isset($items[count($items) - 1]["hasTitle"]) ? $items[count($items)- 1]["hasTitle"] : false;
            $desc = isset($items[count($items) - 1][$lang . "Description"]) ? $items[count($items)- 1][$lang . "Description"] : false;
            $link = isset($items[count($items)- 1]["href"]) ? $items[count($items) - 1]["href"] : false;
            echo "<tr><td></td><td>";
            echo $hasTitle  ? "<div><h3>" . htmlspecialchars($items[count($items) - 1][$lang . "Name"]) . "</h3>" : "";
            echo $desc ? "<figure>" : "";
            echo $link ? "<a class='image-cont' href='" . htmlspecialchars($items[count($items) - 1]["href"]) . "'>" : "<div class='image-cont'>";
            echo "<img src='" . $root . "images/" . 
            (isset($items[count($items)- 1][$lang . "Picture"]) ? htmlspecialchars($items[count($items) - 1][$lang . "Picture"]) : htmlspecialchars($items[count($items)- 1]["picture"])) . 
            "' alt ='" . htmlspecialchars($items[count($items)- 1][$lang . "Name"]) . "'/>";
            echo $link ? "</a>" : "</div>";
            echo $desc ? "<figcaption>" . htmlspecialchars($desc) . "</figcaption></figure>" : "";
            echo $hasTitle ? "</div>" : "";
            echo "</td><td></td></tr>";
            break;
        case 2:
            echo "<tr>";
            for ($i = 0; $i < 2; $i++) {
                $hasTitle = isset($items[count($items) - (2 - $i)]["hasTitle"]) ? $items[count($items) - (2 - $i)]["hasTitle"] : false;
                $desc = isset($items[count($items) - (2 - $i)][$lang . "Description"]) ? $items[count($items) - (2 - $i)][$lang . "Description"] : false;
                $link = isset($items[count($items) - (2 - $i)]["href"]) ? $items[count($items) - (2 - $i)]["href"] : false;
                echo "<td>";
                echo $hasTitle  ? "<div><h3>" . htmlspecialchars($items[count($items) - (2 - $i)][$lang . "Name"]) . "</h3>" : "";
                echo $desc ? "<figure>" : "";
                echo $link ? "<a class='image-cont' href='" . htmlspecialchars($items[count($items) - (2 - $i)]["href"]) . "'>" : "<div class='image-cont'>";
                echo "<img src='" . $root . "images/" . 
                (isset($items[count($items) - (2 - $i)][$lang . "Picture"]) ? htmlspecialchars($items[count($items) - (2 - $i)][$lang . "Picture"]) : htmlspecialchars($items[count($items) - (2 - $i)]["picture"])) . 
                "' alt ='" . htmlspecialchars($items[count($items) - (2 - $i)][$lang . "Name"]) . "'/>";
                echo $link ? "</a>" : "</div>";
                echo $desc ? "<figcaption>" . htmlspecialchars($desc) . "</figcaption></figure>" : "";
                echo $hasTitle ? "</div>" : "";
                echo "</td>";
            }
            echo "</tr>";
            break;
    }

}
?>