/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.codename1.uikit.pheonixui.service;

import com.codename1.io.*;
import com.codename1.ui.Dialog;
import com.codename1.ui.TextField;
import com.codename1.ui.util.Resources;
import com.codename1.uikit.pheonixui.ProfileForm;
import com.codename1.uikit.pheonixui.utils.Statics;
import java.util.Map;

/**
 *
 * @author Boughnimi
 */
public class ServiceUtilisateur {
      //singleton 
    public static ServiceUtilisateur instance = null ;
    
    public static boolean resultOk = true;
    String json;

    //initilisation connection request 
    private ConnectionRequest req;
    
    
    public static ServiceUtilisateur getInstance() {
        if(instance == null )
            instance = new ServiceUtilisateur();
        return instance ;
    }
      public ServiceUtilisateur() {
        req = new ConnectionRequest();
        
    }
      
      
    //Signup
    public void signup(TextField nom,TextField prenom,TextField email,TextField password, TextField numerotelephone , Resources res ) {
        
        String url = Statics.BASE_URL+"/user/signup?nom="+nom.getText().toString()+"&prenom="+prenom.getText().toString()+"&email="+email.getText().toString()+
                "&motdepasse="+password.getText().toString()+"&numerotelephone="+numerotelephone.getText().toString();
        
        req.setUrl(url);
       //Control saisi
        if(nom.getText().equals("") && prenom.getText().equals("") && email.getText().equals("") && password.getText().equals("")&& numerotelephone.getText().equals("")) {
            
            Dialog.show("Erreur","Veuillez remplir les champs","OK",null);
            
        }
        //hethi wa9t tsir execution ta3 url 
        req.addResponseListener((e)-> {
            //njib data ly7atithom fi form 
            byte[]data = (byte[]) e.getMetaData();//lazm awl 7aja n7athrhom ke meta data ya3ni na5o id ta3 kol textField 
            String responseData = new String(data);//ba3dika na5o content 
            System.out.println("data ===>"+responseData);
        }
        );
               NetworkManager.getInstance().addToQueueAndWait(req);
    }
    public void signin(TextField email,TextField password,Resources res)
    {
         String url = Statics.BASE_URL+"/user/signin?email="+email.getText().toString()+"&password"+password.getText().toString();
         req.setUrl(url);
         
          req.addResponseListener((e)-> {
              JSONParser j = new JSONParser();
              String json = new String(req.getResponseData()) + "";
              System.out.println(json);
              try{
                if (json.equals("failed"))
                    Dialog.show("Echec d'authentification","Email ou mot de passe incorrect","OK",null);
              
              else{
                    System.out.println("data =="+json);
                    Map<String,Object> user = j.parseJSON(new CharArrayReader(json.toCharArray()));
                    Preferences.set("id", (int)Float.parseFloat(String.valueOf(user.get("id"))));
                    System.out.println(Preferences.get("id","1"));
                  if (user.size() > 0)
                  {
                  }
              }
              
          }catch (Exception ex){
              ex.printStackTrace();
          }
          
          });
         NetworkManager.getInstance().addToQueueAndWait(req);
    }
    
    public String getPasswordByEmail(String email, Resources rs ) {
        
          // String mp=" "; 
           String url = Statics.BASE_URL+"/user/getPasswordByEmail?email="+email;
           req = new ConnectionRequest(url, false); //false ya3ni url mazlt matba3thtich lel server
           req.setUrl(url);
        
           req.addResponseListener((e) ->{
            
            JSONParser j = new JSONParser();
            
           json = new String(req.getResponseData()) + "";
            
            
            try {
            
          
                System.out.println("data =="+json);
                
                Map<String,Object> password = j.parseJSON(new CharArrayReader(json.toCharArray()));
                
                
            
            
            }catch(Exception ex) {
                ex.printStackTrace();
            }
            
            
            
        });
    
         //ba3d execution ta3 requete ely heya url nestanaw response ta3 server.
        NetworkManager.getInstance().addToQueueAndWait(req);
    return json;
    }
}
