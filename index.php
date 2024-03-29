<html>

<head>
    <title>PHP Starter</title>
    <link rel="stylesheet" href="index.css" />
</head>

<body>
    <?php

    include 'PersonsArray.php';

    function getFullnameFromParts($fullname, $name, $fathername)
    {
        return $fullname . " " . $name . " " . $fathername;
    };


    function getPartsFromFullname($fullname)
    {
        $resultFullname = [];
        $preparationFullname = explode(' ', $fullname);

        for ($i = 0; $i < count($preparationFullname); $i++) {
            if ($i == 0) {
                $resultFullname['surname'] = $preparationFullname[$i];
            } elseif ($i == 1) {
                $resultFullname['name'] = $preparationFullname[$i];
            } elseif ($i == 2) {
                $resultFullname['patronomyc'] = $preparationFullname[$i];
            }
        };
        return $resultFullname;
    };


    function getShortName($fullname)
    {
        $resultFullname = getPartsFromFullname($fullname);
        $resultShortName = $resultFullname['surname'] . " " . mb_substr($resultFullname['name'], 0, 1) . '.';
        return $resultShortName;
    };

    function getShortNameAndFathername($fullname)
    {
        $resultFullname = getPartsFromFullname($fullname);
        $resultShortName = $resultFullname['name'] . " " . mb_substr($resultFullname['patronomyc'], 0, 1) . '.';
        return $resultShortName;
    };

    function getGenderFromName($fullname)
    {
        $sexSign = 0;
        $resultFullname = getPartsFromFullname($fullname);

        if (substr($resultFullname['surname'], -4) == 'ва' || substr($resultFullname['name'], -2) == 'а' || substr($resultFullname['patronomyc'], -6) == 'вна') {
            $sexSign = $sexSign - 1;
        } elseif ((substr($resultFullname['surname'], -2) == 'в' || substr($resultFullname['name'], -2) == 'й' || substr($resultFullname['name'], -2) == 'н' || substr($resultFullname['patronomyc'], -4) == 'ич')) {
            $sexSign = $sexSign + 1;
        };

        if ($sexSign > 0) {
            return 1;
        } elseif ($sexSign < 0) {
            return -1;
        } elseif ($sexSign == 0) {
            return 0;
        }
    };

    function getGenderDescription($examplePersonsArray)
    {
        $male = 0;
        $female = 0;
        $indeterminateGender = 0;

        for ($i = 0; $i < count($examplePersonsArray); ++$i) {

            $gender =  getGenderFromName($examplePersonsArray[$i]['fullname']);

            if ($gender == 1) {
                $male = $male + 1;
            } elseif ($gender == -1) {
                $female = $female + 1;
            } elseif ($gender == 0) {
                $indeterminateGender = $indeterminateGender + 1;
            }
        }

        $totalGender = $male + $female + $indeterminateGender;
        (float)$percentMaleGender = ($male / $totalGender) * 100;
        (float)$percentFemaleGender = ($female / $totalGender) * 100;
        (float)$percentIndeterminateGender = ($indeterminateGender / $totalGender) * 100;

        echo '<span class="hljs-section">Гендерный состав аудитории:<br/>--------------------------- <br/></span>';
        echo ' Мужчины - ' . round($percentMaleGender, 2) . '%<br/>';
        echo 'Женщины - ' . round($percentFemaleGender, 2) . '%<br/>';
        echo 'Не удалось определить - ' . round($percentIndeterminateGender, 2) . '%';
    }

    function getPerfectPartner($fullname, $name, $fathername, $example_persons_array)
    {
        $fullnameLower = mb_strtolower(substr($fullname, 2));
        $firstLetter = mb_strtoupper(substr($fullname, 0, 2));
        $fullname = $firstLetter . $fullnameLower;

        $nameLower = mb_strtolower(substr($name, 2));
        $firstLetter = mb_strtoupper(substr($name, 0, 2));
        $name = $firstLetter . $nameLower;

        $fathernameLower = mb_strtolower(substr($fathername, 2));
        $firstLetter = mb_strtoupper(substr($fathername, 0, 2));
        $fathername = $firstLetter . $fathernameLower;

        $resultFullname = getFullnameFromParts($fullname, $name, $fathername);
        $gender = getGenderFromName($resultFullname);

        $randomMember = $example_persons_array[rand(0, 10)]['fullname'];
        $genderRandomMebmer = getGenderFromName($randomMember);

        while ($gender == $genderRandomMebmer) {
            $randomMember = $example_persons_array[rand(0, 10)]['fullname'];
            $genderRandomMebmer = getGenderFromName($randomMember);
        };
        echo getShortNameAndFathername($resultFullname) . ' + ' . getShortNameAndFathername($randomMember) . ' =<br/> ♡ Идеально на ' . round(rand(5000, 10000) / 100, 2) . '%' . ' ♡';
    }

    getPerfectPartner("ивАнОв", 'иВан', 'иваНовиЧ', $example_persons_array);

    ?>
</body>

</html>