<?php

class c_emojis {
    
    public function obtenerEmojis() {
        //echo '<h4><li>Caras</li></h4>';
        
        $array_grupo_1 = array(
            'em-angel_face',
            'em-anguished_face',
            'em-anxious_with_sweat_face',
            'em-beaming_face',
            'em-blowing_kiss_face',
            'em-blush_heart_eyes_face',
            'em-confused_face',
            'em-crossed_fingers_face',
            'em-disappointed_face',
            'em-fearful_face',
            'em-finger_glasses_face',
            'em-frowning_open_mouth_face',
            'em-grimacing_face',
            'em-grinning_face_1',
            'em-grinning_face_2',
            'em-grinning_face_3',
            'em-grinning_face_4',
            'em-grinning_with_sweat_face',
            'em-heart_eyes_face',
            'em-hide_face',
            'em-hushed_face',
            'em-joke_face',
            'em-joy_face',
            'em-kissing_face',
            'em-laughing_face',
            'em-middle_finger_face',
            'em-murder_face',
            'em-neutral_face',
            'em-no_finger_face',
            'em-no_listen_face',
            'em-no_mouth_face',
            'em-no_see_face',
            'em-no_understand_face',
            'em-ok_hand_face',
            'em-open_mouth_face',
            'em-savoring_food_face',
            'em-screaming_in_fear_face',
            'em-slightly_frowning_face',
            'em-slightly_smiling_face',
            'em-slightly_smiling_face_2',
            'em-slightly_smiling_victory_face',
            'em-smile_floating_hearts_face',
            'em-smiling_face',
            'em-smiling_face_2',
            'em-studying_face',
            'em-surprise_open_mouth_face',
            'em-threat_face',
            'em-thumbs_down_face',
            'em-thumbs_up_face',
            'em-victory_hand_face',
            'em-worried_face',
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