<title>Liste des Commandes</title>
<script>

</script>
<link rel="stylesheet" type="text/css" href="css/listing.css" />
<link rel="stylesheet" type="text/css" href="css/formulaire.css" />
<style type="text/css">
    .new_produit {
        width: 80%;
        margin: auto;
        padding-right: 30px;
        margin-bottom: 0px;
        text-align: right;
    }

    .zone_produit {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-evenly;
        margin-top: 50px;
    }

    .one_image {
        background-color: white;
        width: 400px;
        text-align: center;
        border-radius: 20px;
        margin-bottom: 30px;
        margin-left: 30px;
        margin-right: 30px;
        box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
        transition: transform .3s;
    }

    .one_image:hover {
        -ms-transform: scale(1.05);
        -webkit-transform: scale(1.05);
        transform: scale(1.05);
    }

    .one_image img {
        width: 40%;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
    }

    .titre {
        font-size: 25px;
        margin-bottom: 10px;
    }

    .prix {
        /* font-style: italic; */
        margin-bottom: 10px;
    }

    label {
        /* font-style: italic; */
        margin-left: 8px;
        margin-right: 8px;
    }

    .reduction {
        margin-bottom: 10px;
    }

    form {
        width: 100%;
        margin-top: 20px;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-evenly;
    }
</style>