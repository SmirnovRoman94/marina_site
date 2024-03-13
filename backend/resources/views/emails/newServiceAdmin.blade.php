<!DOCTYPE html>
<html>
<head>
    <title>Новый заказ</title>
    <style lang="css">
        .body{
            background-color: #f6f5e8;
            background-size: contain;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: top;
        }
        h2{
            color: #50735F;
            text-transform: uppercase;
            font-weight: 200;
            text-align: center;
        }
        td, th{
            padding-left: 20px;
            padding-right: 20px;
        }
    </style>
</head>
<body class="body">
<div class="content">
    <h2>Данные о покупке</h2>
    <div style="margin-top: 10px">
        <table>
            <thead>
                <tr>
                    <th>Параметры</th>
                    <th>Сведения</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Имя</td>
                    <td>{{$user->name}}</td>
                </tr>
                <tr>
                    <td>Фамилия</td>
                    <td>{{$user->surname}}</td>
                </tr>
                <tr>
                    <td>Отчество</td>
                    <td>{{$user->patronomic}}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{$user->email}}</td>
                </tr>
                @foreach($user->services as $service)
                    <tr>
                        <td>Приобретенный товар(услуга)</td>
                        <td>{{ $service->title }}</td>
                    </tr>
                    <tr>
                        <td>Количество</td>
                        <td>{{ $service->oder_count }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>Стоимость</td>
                    <td>{{$user->allPrice}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
