/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package service;

import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.ui.events.ActionListener;
import entite.Evenement;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Date;
import java.util.Map;
import java.util.List;

import org.json.simple.JSONObject;
import statics.statics;

/**
 *
 * @author Nidhal
 */
public class ServiceEvenement {

    public ArrayList<Evenement> Evenements;
    //  public ArrayList<Product> listProductForm;

    public static ServiceEvenement instance = null;
    public boolean resultOK;
    private ConnectionRequest req;

    public ServiceEvenement() {
        req = new ConnectionRequest();
    }

    public static ServiceEvenement getInstance() {
        if (instance == null) {
            instance = new ServiceEvenement();
        }
        return instance;
    }

    public ArrayList<Evenement> parseEvenements() {
        try {
            Date today = new Date();
            long oneDay = 60*1000*60*24;
            Evenements = new ArrayList<>();
            JSONParser j = new JSONParser();
            System.out.println(req.getResponseData());
            
           
            Map<String, Object> parsedJson = new JSONParser().parseJSON(new CharArrayReader(
                    new String(req.getResponseData()).toCharArray()
            ));
            List<Map<String, Object>> list = (List<Map<String, Object>>) parsedJson.get("root");
            for (Map<String, Object> obj : list) {
                Evenement t = new Evenement();
                
                
                t.setNom((obj.get("nom").toString()));
                t.setDate((obj.get("date").toString()));
                t.setNbparti((double)(obj.get("nbparti")));
                t.setTarif((double)(obj.get("tarif")));
                t.setLieu((obj.get("lieu").toString()));
                t.setDescription((obj.get("description").toString()));
                t.setNbplace((double)(obj.get("nbplace")));
                
                
               
                

                

                Evenements.add(t);
            }
            /*
            
             Students=new ArrayList<>();
            JSONParser j = new JSONParser();
            Map<String,Object> StudentsListJson = j.parseJSON(new CharArrayReader(jsonText.toCharArray()));
            
            List<Map<String,Object>> list = (List<Map<String,Object>>)StudentsListJson.get("root");
            for(Map<String,Object> obj : list){
                Student t = new Student();
                float id = Float.parseFloat(obj.get("id").toString());
                t.setId((int)id);
                t.setEmail((obj.get("email").toString()));
                    t.setNsc(obj.get("nsc").toString());
                Students.add(t);
            }
             */

        } catch (IOException ex) {

        }
        return Evenements;
    }

    public boolean deleteEvenements(int id) {

        String url = statics.BASE_URL + "api/delete?id=" + id;
        req.setUrl(url);
        req.setPost(false);

        req.addResponseListener(new ActionListener<NetworkEvent>() {
            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200; //Code HTTP 200 OK
                req.removeResponseListener(this); //Supprimer cet actionListener
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return resultOK;
    }

    public ArrayList<Evenement> getAllEvenements() {
        //String url = Statics.BASE_URL+"/Products/";
        Evenements = new ArrayList<>();
        req = new ConnectionRequest();
        String url = statics.BASE_URL+"/api/";
        req.setUrl(url);
        req.setHttpMethod("GET");
        req.addResponseListener(new ActionListener<NetworkEvent>(){
        

            @Override
            public void actionPerformed(NetworkEvent evt) {
                   Evenements = parseEvenements();
                

                req.removeResponseListener(this);
            }

           
        });
        
              
        
        


        NetworkManager.getInstance().addToQueueAndWait(req);
        return Evenements;
    }

    public boolean addEvenement(Evenement F) {
        //String url = Statics.BASE_URL+"/Formation/"+F.getId()+"/"+F.getNom()+"/"+F.getDescription()+"/"+F.getImage()+"/"+F.getPrix()+"/"+F.getDatede()+"/"+F.getDatefin();
        String url = statics.BASE_URL + "api/new?nom=" + F.getNom() + "&date=" + F.getDate()+ "&nbparti=" + F.getNbparti()+ "&tarif=" + F.getTarif() + "&lieu=" + F.getLieu() + "&description=" + F.getDescription()+ "&nbplace=" + F.getNbplace() + "&nbjoursrestant=" + F.getNbjoursrestant()+ "&nbplacerest=" + F.getNbplacerest();
        req.setUrl(url);
        req.setPost(false);
        req.addResponseListener(new ActionListener<NetworkEvent>() {

            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200;
                req.removeResponseCodeListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return resultOK;
    }

    public boolean updateEvenement(Evenement F) {
        //String url = Statics.BASE_URL+"/Formation/"+F.getId()+"/"+F.getNom()+"/"+F.getDescription()+"/"+F.getImage()+"/"+F.getPrix()+"/"+F.getDatede()+"/"+F.getDatefin();
        String url = statics.BASE_URL + "api/edit?id=" + F.getId() + "&nom=" + F.getNom() + "&date=" + F.getDate()+ "&nbparti=" + F.getNbparti()+ "&tarif=" + F.getTarif() + "&lieu=" + F.getLieu() + "&description=" + F.getDescription()+ "&nbplace=" + F.getNbplace() + "&nbjoursrestant=" + F.getNbjoursrestant()+ "&nbplacerest=" + F.getNbplacerest();
        req.setUrl(url);
        req.setPost(false);
        req.addResponseListener(new ActionListener<NetworkEvent>() {

            @Override
            public void actionPerformed(NetworkEvent evt) {
                resultOK = req.getResponseCode() == 200;
                req.removeResponseCodeListener(this);
            }
        });
        NetworkManager.getInstance().addToQueueAndWait(req);
        return resultOK;
    }
}
