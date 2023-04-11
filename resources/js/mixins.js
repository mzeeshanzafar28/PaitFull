export default {
    methods: {
        playAudio(fileName){
            let audio = new Audio(`${this.$audioUrl}${fileName}`);
            audio.play();
        }
    },
}