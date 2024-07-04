<?php
/**
 * Function that takes a set of rows from the monster_cards card table and returns a string representing all the types a card has and the card frame
 * 
 * @param $result The rows from the monster_cards table
 * @return array An array where the first element is a string representing all the types a card has and the second element is the type that determines the frame of the card
 */
function getCardType($row)
{
    $fullType = "[" . $row["type"];
    $primary_types = array("Ritual", "Fusion", "Synchro", "Xyz", "Link");
    $secondary_types = array("Toon", "Spirit", "Union", "Gemini", "Flip");
    $className = "";

    foreach ($primary_types as $type) {
        if ($row[strtolower($type)] == 1) {
            $className = $type;
            $fullType .= "/" . $type;
            break;
        }
    }

    foreach ($secondary_types as $type) {
        if ($row[strtolower($type)] == 1) {
            $fullType .= "/" . $type;
            break;
        }
    }

    if ($row["pendulum"] == 1) {
        $className .= " pendulum";
        $fullType .= "/Pendulum";
    }

    if ($row["tuner"] == 1) {
        $fullType .= "/Tuner";
    }

    if ($row["effect"] == 1) {
        $className .= " effect";
        $fullType .= "/Effect";
    } else {
        $className .= " normal";
    }
    return (array($fullType . ']', $className));
}

/**
 * Function that takes a set of rows from the monster_cards card table and outputs the results
 * 
 * @param $result The rows from the monster_cards table
 */
function createMonsterCards($result)
{
    foreach ($result as $row) {
        $number = $row["number"];
        $name = $row["name"];
        $cardTypes = getCardType($row);
        $type = $cardTypes[0];
        $className = $cardTypes[1];
        $attribute = $row["attribute"];
        if ($row["xyz"] == 1) {
            $levelType = "Rank: ";
        } else if ($row["link"] == 1) {
            $levelType = "Link Rating: ";
        } else {
            $levelType = "Level: ";
        }
        $level = $row["level"];
        $attack = $row["attack"];
        $defense = $row["defense"];
        echo
            "<tr>
            <th scope ='row' class = {$className}> {$number}</th>
            <td class = {$className}>{$name}</td>
            <td class = {$className}>{$type}</td>
            <td class = {$className}>{$attribute}</td>
            <td class = {$className}>{$level}</td>
            <td class = {$className}>{$attack}</td>
            <td class = {$className}>{$defense}</td>
        </tr>";
    }
}

/**
 * Function that takes a set of rows from the spell_trap_cards card table and outputs the results
 * 
 * @param $result The rows from the spell_trap_cards table
 */
function createSpellTrapCards($result)
{
    foreach ($result as $row) {
        $number = $row["number"];
        $name = $row["name"];
        $frame = $row["frame"];
        $type = $row["type"];
        $className = $frame == "Spell" ? "spell" : "trap";
        echo
            "<tr>
            <th scope ='row' class={$className}> {$number}</th>
            <td class = {$className}>{$name}</td>
            <td class = {$className}>{$type} {$frame}</td>
            <td class = {$className}></td>
            <td class = {$className}></td>
            <td class = {$className}></td>
            <td class = {$className}></td>
        </tr>";
    }
}
