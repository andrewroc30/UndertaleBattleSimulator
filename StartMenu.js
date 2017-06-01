UndertaleBattleSimulator.StartMenu = function(game) {
	this.startBG;
    this.startTitle;
	this.startPrompt;
    this.ding;
};

UndertaleBattleSimulator.StartMenu.prototype = {
	
	create: function () {
        this.ding = this.add.audio('select_audio');
        
		startBG = this.add.image(0, 0, 'titlescreen');
		startBG.inputEnabled = true;
		startBG.events.onInputDown.addOnce(this.startGame, this);
        
        startTitle = this.add.bitmapText(this.world.centerX-600, this.world.centerY-200, 'eightbitwonder', 'Undertale Battle Simulator', 48);
		startTitle.inputEnabled = true;
		startTitle.events.onInputDown.addOnce(this.startGame, this);
        
		startPrompt = this.add.bitmapText(this.world.centerX-205, this.world.centerY+180, 'eightbitwonder', 'Click Anywhere to Start!', 24);
        startPrompt.inputEnabled = true;
		startPrompt.events.onInputDown.addOnce(this.startGame, this);
	},

	startGame: function (pointer) {
        this.ding.play();
		this.state.start('Game');
	}
};