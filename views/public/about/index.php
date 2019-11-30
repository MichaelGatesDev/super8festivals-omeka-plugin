<?php
$head = array(
    'title' => "About",
);
echo head($head);
?>

<?php echo flash(); ?>

<section class="container">

    <div class="row">
        <div class="col">
            <h2>About</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-2">
            <img src="<?= img("placeholder-200x200.svg", "images"); ?>" class="img-fluid img-thumbnail" width="300px" height="300px" alt="Responsive image">
        </div>
        <div class="col">
            <p>
                I am a professor of Spanish and film at the State Univeristy of New York in Plattsburgh.
                In 2008 I received a Fulbright grant to study the films of Venezuelan avant-garde filmmaker
                Diego Rísquez. My intention was to examine Rísquez’s work from an author theory perspective.
                A collection of newspaper clippings in Rísquez’s archive changed my mind. At this point I did
                not even know what Super 8 was. Yet, I became eager to find out more about the young
                filmmakers in the newspaper. They had maintained a transnational network, the International
                Federation of Super 8 Cinema, outside of regional or national institutions.
            </p>
            <p>
                Meeting these filmmakers was fascinating but took a long time. It took over ten years as
                filmmakers lived in over twenty countries and I received little funding for my project. Most
                funding sources were not interested in Super 8 culture. In some cases, I interviewed people at
                airports between flights or took side trips after conferences or visiting relatives. The biggest
                challenge, however, was not locating and meeting people, but writing about the fascinating
                world I discovered.
            </p>
            <p>
                Finding ways to write about people in the twenty countries interacting with each other
                was challenging. For that, I wrote Small Gauge, Big Dreams, a book that focuses on Super 8 as a
                technology that allowed the establishment of one of the first de-centralized, transnational,
                cinematic networks.
            </p>
            <p>
                My second challenge was to document my findings. Only in rare instances had local,
                regional or national archives collect the films, photographs, and catalogs that filmmakers had
                kept in their attics. This meant that readers could not go to their libraries or a website to view
                the objects or documents I cite in the book. For that, I created this website.
            </p>
        </div>
    </div>


</section>

<?php echo foot(); ?>
