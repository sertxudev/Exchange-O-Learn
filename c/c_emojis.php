<?php

class c_emojis {
    
    public function obtenerEmojis() {        
        $array_grupo_1 = array(
            'em_angel_face',
            'em_anguished_face',
            'em_anxious_face_with_sweat',
            'em_beaming_face',
            'em_blowing_kiss_face',
            'em_blush_heart_eyes_face',
            'em_confused_face',
            'em_crossed_fingers_face',
            'em_disappointed_face',
            'em_face_savoring_food',
            'em_fearful_face',
            'em_finger_glasses_face',
            'em_frowning_face',
            'em_frowning_open_mouth_face',
            'em_grimacing_face',
            'em_grinning_face',
            'em_grinning_face_with_big_eyes',
            'em_grinning_face_with_big_mouth',
            'em_grinning_face_with_smiling_eyes',
            'em_grinning_face_with_sweat',
            'em_grinning_squinting_face',
            'em_hide_face',
            'em_hushed_face',
            'em_joke_face',
            'em_joy_face',
            'em_kissing_face_with_smiling_eyes',
            'em_mid_slightly_smiling_face',
            'em_middle_finger_face',
            'em_neutral_face',
            'em_no_finger_face',
            'em_no_listen_face',
            'em_no_mouth_face',
            'em_no_see_face',
            'em_no_understand_face',
            'em_ok_hand_face',
            'em_screaming_in_fear_face',
            'em_slightly_frowning_face',
            'em_slightly_smiling_face',
            'em_slightly_smiling_victory_face',
            'em_smiling_face',
            'em_smiling_face_with_sunglasses',
            'em_studying_face',
            'em_surprise_open_mouth_face',
            'em_thinking_flushed_face',
            'em_thumbs_down_face',
            'em_thumbs_up_face',
            'em_victory_hand_face',
            'em_winking_face',
            'em_worried_face',
            'em_zipper_mouth_face',
            'em_poo',
        );
        foreach ($array_grupo_1 as $v) {
            echo '<i onClick="sendEmoji(\'' . $v . '\')" style="font-size: 40px;" class="em ' . $v . '"></i>';
        }
    }
}
