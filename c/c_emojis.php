<?php

class c_emojis {
    
    public function obtenerEmojis() {
        //echo '<h4><li>Caras</li></h4>';
        
        $array_grupo_1 = array(
            'em-grinning',
            'em-smiley',
            'em-smile',
            'em-laughing',
            'em-sweat_smile',
            'em-joy',
            'em-grimacing',
            'em-grin',
            'em-blush',
            'em-relaxed',
            'em-innocent',
            'em-wink',
            'em-kissing',
            'em-kissing_smiling_eyes',
            'em-kissing_face',
            'em-kissing_heart',
            'em-heart_eyes',
            'em-sleepy',
            'em-sleeping',
            'em-disappointed_relieved',
            'em-cry',
            'em-sweat',
            'em-flushed',
            'em-fearful',
            'em-cold_sweat',
            'em-scream',
            'em-sob',
            'em-open_mouth',
            'em-hushed',
            'em-frowning',
            'em-anguished',
            'em-worried',
            'em-astonished',
            'em-dizzy_face',
            'em-disappointed',
            'em-persevere',
            'em-confounded',
            'em-weary',
            'em-tired_face',
            'em-confused',
            'em-angry',
            'em-very_angry',
            'em-triumph',
            'em-stuck_out_tongue',
            'em-stuck_out_tongue_winking_eye',
            'em-stuck_out_tongue_closed_eyes',
            'em-yum',
            'em-neutral_face',
            'em-expressionless',
            'em-mask',
            'em-no_mouth',
            'em-unamused',
            'em-pensive',
            'em-relieved',
            'em-smirk',
            'em-nerd',
            'em-sunglasses',
        );
        
        $array_grupo_2 = array(
            'em-smile_cat',
            'em-smiley_cat',
            'em-smirk_cat',
            'em-heart_eyes_cat',
            'em-kissing_cat',
            'em-joy_cat',
            'em-crying_cat_face',
            'em-scream_cat',
            'em-full_moon_with_face',
            'em-new_moon_with_face',
            'em-monkey_face',
            'em-hear_no_evil',
            'em-see_no_evil',
            'em-speak_no_evil',
            'em-ghost',
            'em-shit',
            'em-alien',
            'em-baby',
            'em-angel',
            'em-imp',
            'em-woman',
            'em-man'
        );
        
        
        foreach ($array_grupo_1 as $v) {
            echo '<i onClick="sendEmoji(emoji)" style="font-size: 25px;" class="em ' . $v . '"></i>';
        }
        echo '<hr>';
        
        foreach ($array_grupo_2 as $v) {
            echo '<i onClick="sendEmoji(emoji)" style="font-size: 25px;" class="em ' . $v . '"></i>';
        }
        echo '<hr>';
        
    }
}