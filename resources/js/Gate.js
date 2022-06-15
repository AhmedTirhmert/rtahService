export default class Gate{

    constructor(user){
        this.user = user;
    }

    isAdmin(){
        return this.user.role.name.toLowerCase() === 'admin';
    }

    isClient(){
        return this.user.role.name.toLowerCase() === 'client';
    }
    isFournisseur(){
        return this.user.role.name.toLowerCase() === 'fournisseur';
    }
    
    isAdminOrUser(){
        if(this.user.role.name.toLowerCase() === 'user' || this.user.role.name.toLowerCase() === 'admin'){
            return true;
        }
    }
}

