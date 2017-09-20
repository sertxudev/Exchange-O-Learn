<?php

class c_emojis {
    
    public function obtenerEmojis() {
        //echo '<h4><li>Caras</li></h4>';
        
        $array_grupo_1 = array(
            'em_angel_face',
            'em_anguished_face',
            'em_anxious_with_sweat_face',
            'em_beaming_face',
            'em_blowing_kiss_face',
            'em_blush_heart_eyes_face',
            'em_confused_face',
            'em_crossed_fingers_face',
            'em_disappointed_face',
            'em_fearful_face',
            'em_finger_glasses_face',
            'em_frowning_open_mouth_face',
            'em_grimacing_face',
            'em_grinning_face_1',
            'em_grinning_face_2',
            'em_grinning_face_3',
            'em_grinning_face_4',
            'em_grinning_with_sweat_face',
            'em_heart_eyes_face',
            'em_hide_face',
            'em_hushed_face',
            'em_joke_face',
            'em_joy_face',
            'em_kissing_face',
            'em_laughing_face',
            'em_middle_finger_face',
            'em_murder_face',
            'em_neutral_face',
            'em_no_finger_face',
            'em_no_listen_face',
            'em_no_mouth_face',
            'em_no_see_face',
            'em_no_understand_face',
            'em_ok_hand_face',
            'em_open_mouth_face',
            'em_savoring_food_face',
            'em_screaming_in_fear_face',
            'em_slightly_frowning_face',
            'em_slightly_smiling_face',
            'em_slightly_smiling_face_2',
            'em_slightly_smiling_victory_face',
            'em_smile_floating_hearts_face',
            'em_smiling_face',
            'em_smiling_face_2',
            'em_studying_face',
            'em_surprise_open_mouth_face',
            'em_threat_face',
            'em_thumbs_down_face',
            'em_thumbs_up_face',
            'em_victory_hand_face',
            'em_worried_face',
            'em_monster_energy',
            'em_poo',
        );

        $array_grupo_2 = array(
            'ba_1',
            'ba_2',
            'ba_3',
            'ba_4',
        );
        
        foreach ($array_grupo_1 as $v) {
            echo '<i onClick="sendEmoji(\'' . $v . '\')" style="font-size: 45px;" class="em ' . $v . '"></i>';
        }
        echo '<hr>';
        
        foreach ($array_grupo_2 as $v) {
            echo '<i onClick="sendEmoji(\'' . $v . '\')" style="font-size: 193px;" class="em ' . $v . '"></i>';
        }
        echo '<hr>';
        
    }
}