<!doctype html>
<html lang="en">
<head>
<title>Code generator</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/4.0.0/cosmo/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col">
            <h3>Form</h3>
            <form id="generateForm">
                <div class="form-group">
                    <label for="namespace">Namespace</label>
                    <input type="text" class="form-control" id="namespace">
                </div>
                <div class="form-group">
                    <label for="valueObject">ValueObject</label>
                    <input type="text" class="form-control" id="valueObject">
                </div>
                <div class="form-group">
                    <label for="validValues">Valid Values</label>
                    <textarea class="form-control" id="validValues" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="invalidValues">Invalid Values</label>
                    <textarea class="form-control" id="invalidValues" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" id="generate">Generate</button>
            </form>
        </div>
        <div class="col">
            <h3>Generated Code</h3>
<pre style="background-color: #000; color: #fff; padding: 10px;"><code id="generatedCode"></code></pre>
        </div>
    </div>
</div>

<script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script type="text/javascript">

    $(function(){

        $("#generateForm").submit(function (evt) {
            evt.preventDefault();

            $.post("/generate.php", {
                namespace: $("#namespace").val(),
                valueObject: $("#valueObject").val(),
                validValues: $("#validValues").val(),
                invalidValues: $("#invalidValues").val(),
            }).done(function(generated) {
                $("#generatedCode").text(generated);
            }).fail(function() {
                alert("Something went wrong");
            });
        });
    });

</script>

</body>
</html>
