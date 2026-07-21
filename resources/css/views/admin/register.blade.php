<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evNxOUQCT79PpJrYLbAELcX3zUbx9CnXL9EUYKzONQW/zC832LKzis9R0N/Ouk4T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/mdb-ui-kit@5/css/mdb.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            /* Light gray background */
        }

        .register-form {
            max-width: 400px;
            /* Adjust width as needed */
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin: 0 auto;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #007bff;
            /* Blue button */
        }
    </style>
</head>

<!-- <body>
    <div class="container mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 register-form">
                <h1>Admin Register</h1>
                <form action="{{ route('custom_registerPost') }}" method="POST">
                    @csrf
                    <div class="form-outline mb-4">
                        <input type="name" id="name" name="name" class="form-control" />
                        <label class="form-label" for="name">Name</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="email" id="email" name="email" class="form-control" />
                        <label class="form-label" for="email">Email address</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="password" id="password" name="password" class="form-control" />
                        <label class="form-label" for="password">Password</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mb-4">Register</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OgwbZS7/BXzYhFOT11tTznCtq7zYjLNUovqESGruoD8sJKplHsQxidulGhzqS1MQ" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.js"></script>
</body> -->

</html>