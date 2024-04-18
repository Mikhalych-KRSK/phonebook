<?php

$contacts = json_decode(file_get_contents('contacts.json'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['name']) && !empty($_POST['phone'])) {
    $newContact = [
        'name' => $_POST['name'],
        'phone' => $_POST['phone']
    ];
    
    $contacts[] = $newContact;
    
    file_put_contents('contacts.json', json_encode($contacts));
    
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $deleteName = $_POST['delete'];
    foreach ($contacts as $key => $contact) {
        if ($contact['name'] === $deleteName) {
            unset($contacts[$key]);
        }
    }
    
    file_put_contents('contacts.json', json_encode(array_values($contacts)));
    
    header('Location: index.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Телефонный справочник</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class="container">
            <h1>Телефонный справочник</h1>

            <h2>Добавить контакт</h2>
            <form method="post">
                <label for="name">Имя:</label>
                <input type="text" name="name" id="name" required><br>
                
                <label for="phone">Телефонный номер:</label>
                <input type="text" name="phone" id="phone" required><br>
                
                <button type="submit">Добавить</button>
            </form>

            <h2>Список контактов</h2>
            <ul>
                <?php foreach ($contacts as $contact): ?>
                    <li>
                        <?php echo $contact['name']; ?> : <?php echo $contact['phone']; ?>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="delete" value="<?php echo $contact['name']; ?>">
                            <button type="submit">Удалить</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </body>
</html>
