export default class Gate{

    constructor(user){
        this.user = user;
    }

    isAdmin(){
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

