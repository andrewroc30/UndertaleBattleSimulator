UndertaleBattleSimulator.Preloader = function(game) {
    this.preloadBar = null;
    this.titleText = null;
    this.ready = false;
};

UndertaleBattleSimulator.Preloader.prototype = {

    preload: function () {
        this.preloadBar = this.add.sprite(this.world.centerX, this.world.centerY, 'preloaderBar');
        this.preloadBar.anchor.setTo(0.5, 0.5);
        this.load.setPreloadSprite(this.preloadBar);
        this.titleText = this.add.image(this.world.centerX, this.world.centerY-220, 'titleimage');
        this.titleText.anchor.setTo(0.5, 0.5);
        this.load.image('titlescreen', 'images/UndertaleBattleSimulatorTitleBG.png');
        this.load.bitmapFont('eightbitwonder', 'fonts/eightbitwonder.png', 'fonts/eightbitwonder.fnt');
        this.load.image('heart', 'images/UndertaleHeartEdited.png');
        this.load.image('pellet', 'images/FrendlinessPellet.png');
        this.load.audio('select_audio', 'audio/select.mp3');
        this.load.audio('game_audio', 'audio/bgm.mp3');
    },

    create: function () {
        this.preloadBar.cropEnabled = false; //force show the whole thing
    },

    update: function () {
        if(this.cache.isSoundDecoded('game_audio') && this.ready == false){
            this.ready = true;
            this.state.start('StartMenu');
        }
    }
};