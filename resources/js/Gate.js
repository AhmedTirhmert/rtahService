export default class Gate{

    constructor(user){
        this.user = user;
        console.log(user);
    }

    isAdmin(){
        console.log(this.user.type);
        return this.user.type.toLowerCase() === 'admin';
    }

    isUser(){
        return this.user.type.toLowerCase() === 'user';
    }
    
    isAdminOrUser(){
        if(this.user.type === 'user' || this.user.type === 'admin'){
            return true;
        }
    }
}

