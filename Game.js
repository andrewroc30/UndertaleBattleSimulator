UndertaleBattleSimulator.Game = function (game) {
    this.gameover;
    this.counter;
    this.overmessage;
    this.secondsElapsed;
    this.timer;
    this.music;
    this.ouch;
    this.boom;
    this.ding;
    this.sprite;
    this.upKey;
    this.downKey;
    this.leftKey;
    this.rightKey;
    this.upKeyW;
    this.downKeyS;
    this.leftKeyA;
    this.rightKeyD;
    this.restartKey;
    this.bullets;
    this.bulletTime = 0;
    this.score;
};

UndertaleBattleSimulator.Game.prototype = {

    create: function () {
        this.gameover = false;
        this.secondsElapsed = 0;
        this.timer = this.time.create(false);
        this.timer.loop(1000, this.updateSeconds, this);
        /*this.totalBunnies = 20;
        this.totalSpacerocks = 13;*/

        this.score = 0;

        this.game.physics.startSystem(Phaser.Physics.ARCADE);

        this.sprite = this.add.sprite(800, 400, 'heart');  
        this.sprite.velocity = 0;
        this.sprite.enableBody = true;

        this.bullets = this.game.add.group();
        this.bullets.enableBody = true;
        this.bullets.physicsBodyType = Phaser.Physics.ARCADE;
        this.bullets.createMultiple(30, 'pellet');
        this.bullets.setAll('anchor.x', 0.5);
        this.bullets.setAll('anchor.y', 1);
        this.bullets.setAll('outOfBoundsKill', true);
        this.bullets.setAll('checkWorldBounds', true);

        this.game.physics.arcade.enable([this.sprite, this.bullets]);

        upKey = this.input.keyboard.addKey(Phaser.Keyboard.UP);
        downKey = this.input.keyboard.addKey(Phaser.Keyboard.DOWN);
        leftKey = this.input.keyboard.addKey(Phaser.Keyboard.LEFT);
        rightKey = this.input.keyboard.addKey(Phaser.Keyboard.RIGHT);
        upKeyW = this.input.keyboard.addKey(Phaser.Keyboard.W);
        downKeyS = this.input.keyboard.addKey(Phaser.Keyboard.S);
        leftKeyA = this.input.keyboard.addKey(Phaser.Keyboard.A);
        rightKeyD = this.input.keyboard.addKey(Phaser.Keyboard.D);
        restartKey = this.input.keyboard.addKey(Phaser.Keyboard.R);


        this.music = this.add.audio('game_audio');
        this.music.play('', 0, 0.3, true);   //marker, position, volume, loop
        this.ouch = this.add.audio('hurt_audio');
        this.boom = this.add.audio('explosion_audio');
        this.ding = this.add.audio('select_audio');
        this.buildWorld();
    },

    updateSeconds: function(){
        this.secondsElapsed++;
    },

    buildWorld: function () {
        /*this.add.image(0, 0, 'sky');
        this.add.image(0, 800, 'hill');
        this.buildBunnies();
        this.buildSpaceRocks();
        this.buildEmitter();*/
        this.counter = this.add.bitmapText(10, 10, 'eightbitwonder', 'Score: ' + this.score, 0);
        this.timer.start();
    },

    buildBunnies: function () {
        this.bunnygroup = this.add.group();
        this.bunnygroup.enableBody = true;
        for (var i=0; i<this.totalBunnies; i++) {
            var b = this.bunnygroup.create(this.rnd.integerInRange(-10, this.world.width-50), this.rnd.integerInRange(this.world.height-180, this.world.height-60), 'heart', 'Bunny0000');
            b.anchor.setTo(0.5, 0.5); //center point for bunnies
            b.body.moves = false;
            //b.animations.add('Rest', this.game.math.numberArray(1,58));
            //b.animations.add('Walk', this.game.math.numberArray(68,107));
            //b.animations.play('Rest', 24, true);
            this.assignBunnyMovement(b);
        }
    },

    /*assignBunnyMovement: function (b) {
        bposition = Math.floor(this.rnd.realInRange(50, this.world.width-50));
        bdelay = this.rnd.integerInRange(2000, 6000);
        if(bposition < b.x){
            b.scale.x = 1;
        }else{
            b.scale.x = -1;
        }
        t = this.add.tween(b).to({x:bposition}, 3500, Phaser.Easing.Quadratic.InOut, true, bdelay); //properties, duration, ease, autoStart, delay
        t.onStart.add(this.startBunny, this);
        t.onComplete.add(this.stopBunny, this);
    },

    startBunny: function (b) {
        //b.animations.stop('Rest');
        //b.animations.play('Walk', 24, true);
    },

    stopBunny: function (b) {
        //b.animations.stop('Walk');
        //b.animations.play('Rest', 24, true);
        this.assignBunnyMovement(b);
    },

    buildSpaceRocks: function() {
        this.spacerockgroup = this.add.group();
        for(var i=0; i<this.totalSpacerocks; i++) {
            var r = this.spacerockgroup.create(this.rnd.integerInRange(0, this.world.width), this.rnd.realInRange(-1500, 0), 'spacerock', 'SpaceRock0000');
            var scale = this.rnd.realInRange(0.3, 1.0);
            r.scale.x = scale;
            r.scale.y = scale;
            this.physics.enable(r, Phaser.Physics.ARCADE);
            r.enableBody = true;
            r.body.velocity.y = this.rnd.integerInRange(200, 400);
            r.animations.add('Fall');
            r.animations.play('Fall', 24, true);
            r.checkWorldBounds = true;
            r.events.onOutOfBounds.add(this.resetRock, this);
        }
    },

    resetRock: function(r) {
        if(r.y > this.world.height){
            this.respawnRock(r);
        }
    },

    respawnRock: function(r) {
        if(this.gameover == false){
            r.reset(this.rnd.integerInRange(0, this.world.width), this.rnd.realInRange(-1500, 0));
            r.body.velocity.y = this.rnd.integerInRange(200, 400);
        }
    },

    buildEmitter:function() {
        this.burst = this.add.emitter(0, 0, 80);
        this.burst.minParticleScale = 0.3;
        this.burst.maxParticleScale = 1.2;
        this.burst.minParticleSpeed.setTo(-30, 30);
        this.burst.maxParticleSpeed.setTo(30, -30);
        this.burst.makeParticles('explosion');
        this.input.onDown.add(this.fireBurst, this);
    },

    fireBurst: function(pointer) {
        if(this.gameover == false){
            this.boom.play();
            this.boom.volume = 0.2;
            this.burst.emitX = pointer.x;
            this.burst.emitY = pointer.y;
            this.burst.start(true, 2000, null, 20); //(explode, lifespan, frequency, quantity)
        }
    },

    burstCollision : function(r, b){
        this.respawnRock(r);
    },

    bunnyCollision : function(r, b){
        if(b.exists){
            this.ouch.play();
            this.makeGhost(b);
            this.respawnRock(r);
            b.kill();
            this.totalBunnies--;
            this.checkBunniesLeft();
        }
    },

    checkBunniesLeft : function(){
        if(this.totalBunnies <= 0){
            this.gameover = true;
            this.music.stop();
            this.countdown.setText('Bunnies Left 0');
            this.overmessage = this.add.bitmapText(this.world.centerX-180, this.world.centerY-40, 'eightbitwonder', 'GAME OVER\n\n' + this.secondsElapsed, 42);
            this.overmessage.align = "center";
            this.overmessage.inputEnabled = true;
            this.overmessage.events.onInputDown.addOnce(this.quitGame, this);
        }
        else{
            this.countdown.setText('Bunnies Left ' + this.totalBunnies);
        }
    },*/

    quitGame: function(pointer){
        $.get("transmitter.php", {score: this.score},
              function(data){
            console.log("Data: " + data);
        });
        if(restartKey.isDown){
            this.ding.play();
            this.state.start(this.state.current);
        }
    },

    /*makeGhost: function(b) {
        bunnyghost = this.add.sprite(b.x-20, b.y-180, 'ghost');
        bunnyghost.anchor.setTo(0.5, 0.5);
        bunnyghost.scale.x = b.scale.x;
        this.physics.enable(bunnyghost, Phaser.Physics.ARCADE);
        bunnyghost.enableBody = true;
        bunnyghost.checkWorldBounds = true;
        bunnyghost.body.velocity.y = -800;
    },*/

    movement: function(){
        if (upKey.isDown || upKeyW.isDown){
            this.sprite.y -= 5;
        }
        else if (downKey.isDown || downKeyS.isDown){
            this.sprite.y += 5;
        }
        if (leftKey.isDown || leftKeyA.isDown){
            this.sprite.x -= 5;
        }
        else if (rightKey.isDown || rightKeyD.isDown){
            this.sprite.x += 5;
        }
    },

    boundsCollision: function(){
        if(this.sprite.x <= 0 || this.sprite.x >= 1580 || this.sprite.y <= 0 || this.sprite.y >= 780){
            if (leftKey.isDown || leftKeyA.isDown){
                this.sprite.x += 5;
            }
            else if (rightKey.isDown || rightKeyD.isDown){
                this.sprite.x -= 5;
            }
            if (upKey.isDown || upKeyW.isDown){
                this.sprite.y += 5;
            }
            else if (downKey.isDown || downKeyS.isDown){
                this.sprite.y -= 5;
            }
        }
    },

    enemyHitsPlayer: function(){
        this.sprite.kill();
        this.gameover = true;
        //this.bullets.kill();
        this.timer.pause();
        this.music.stop();
        this.overmessage = this.add.bitmapText(this.world.centerX-180, this.world.centerY-40, 'eightbitwonder', 'GAME OVER\n\n' + 'Score:  ' + this.score, 42);
        this.overmessage.align = "center";
        this.overmessage.inputEnabled = true;
        this.overmessage.events.onInputDown.addOnce(this.quitGame, this);     
    },

    fireBullet: function(){

        //To avoid them being allowed to fire too fast we set a time limit
        if (this.game.time.now > this.bulletTime)
        {
            //Grab the first bullet we can from the pool
            this.bullet = this.bullets.getFirstExists(false);

            if (this.bullet){
                //And fire it
                this.tooClose = true;
                while(this.tooClose == true){
                    this.bullet.reset(Math.random() * 1600, Math.random() * 800);
                    if(this.bullet.body.x > (this.sprite.x + 300) || this.bullet.body.x < (this.sprite.x - 300) || this.bullet.body.y > (this.sprite.y + 300) || this.bullet.body.y < (this.sprite.y - 300)){
                        this.tooClose = false;
                    }
                    else{
                        this.bullet.kill();
                    }
                }
                this.directionUpdate(this.bullet);
                this.bulletTime = this.game.time.now + 200;
            }
        }
    },

    directionUpdate: function(bullt) {

        // Calculate direction towards player
        this.toPlayerX = this.sprite.x - bullt.body.x;
        this.toPlayerY = this.sprite.y - bullt.body.y;

        // Move towards the player
        bullt.body.velocity.x = this.toPlayerX;
        bullt.body.velocity.y = this.toPlayerY;

        // Rotate us to face the player
        bullt.rotation = Math.atan2(this.toPlayerY, this.toPlayerX);
    },

    updateSeconds: function(){
        this.score++;
        this.counter.text = 'Score: ' + this.score;
    },

    killBullets: function(){
        this.bullets.forEachAlive(function(bullet){
            if(bullet.body.x > 1600 || bullet.body.x < 0 || bullet.body.y > 800 || bullet.body.y < 0){
                bullet.kill();
            }
        }, this)
    },

    update: function() {
        //this.physics.arcade.overlap(this.spacerockgroup, this.burst, this.burstCollision, null, this);
        //this.physics.arcade.overlap(this.spacerockgroup, this.bunnygroup, this.bunnyCollision, null, this);
        //this.physics.arcade.overlap(this.bunnygroup, this.burst, this.friendlyFire, null, this);
        if(this.gameover == false){
            this.fireBullet();
            this.physics.arcade.overlap(this.sprite, this.bullets, this.enemyHitsPlayer, null, this);
            //this.physics.arcade.overlap(this.bullets, this.bullets, this.enemyHitsPlayer, null, this);
            //this.physics.arcade.collide(this.sprite, this.bullets);
            this.movement();
            this.boundsCollision();
            this.killBullets();
        }
        else{
            this.quitGame();
        }
    }

};