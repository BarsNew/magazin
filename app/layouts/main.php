<main class="main">
    <div class="container">
        <?php if ($path != 'home') echo '<h1 class="main-h1">' . $data['header'] . '</h1>'; ?> 
        <div><?php echo $data['content']; ?></div>
    </div>
</main>