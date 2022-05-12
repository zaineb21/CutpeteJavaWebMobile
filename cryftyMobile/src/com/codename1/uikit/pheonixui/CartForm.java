package com.codename1.uikit.pheonixui;

import com.codename1.ui.*;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.layouts.FlowLayout;
import com.codename1.ui.spinner.Picker;
import com.codename1.ui.table.DefaultTableModel;
import com.codename1.ui.table.Table;
import com.codename1.ui.table.TableLayout;
import com.codename1.ui.table.TableModel;
import com.codename1.uikit.pheonixui.model.Product;
import com.codename1.uikit.pheonixui.service.CartService;

import java.util.ArrayList;

public class CartForm extends BaseForm {
    public CartForm() {
        this(com.codename1.ui.util.Resources.getGlobalResources());
    }
    
    public CartForm(com.codename1.ui.util.Resources resourceObjectInstance) {
        initGuiBuilderComponents(resourceObjectInstance);
        getToolbar().setTitleComponent(
                FlowLayout.encloseCenterMiddle(
                        new Label("Cart", "Title"),
                        new Label(String.valueOf(CartService.getInstance().getProducts().size()), "InboxNumber")
                )
        );
        installSidemenu(resourceObjectInstance);
        getToolbar().addCommandToRightBar("", resourceObjectInstance.getImage("toolbar-profile-pic.png"), e -> {});
        ArrayList<Product> products = CartService.getInstance().getProducts();
        Object[][] rows = new Object[products.size()][];

        for(int iter = 0 ; iter < rows.length ; iter++) {
            rows[iter] = new Object[] {
                    products.get(iter).getName(), products.get(iter).getPrice(), products.get(iter).getQuantToBuy()
            };
        }
        TableModel model = new DefaultTableModel(new String[] {"Name", "Price", "Quantity"}, rows) {
            public boolean isCellEditable(int row, int col) {
                return col != 0;
            }
        };

        Table table = new Table(model) {
            @Override
            protected Component createCell(Object value, int row, int column, boolean editable) {
                Component cell;
                if(column == 2 && row>-1) {
                    Picker p = new Picker();
                    p.setType(Display.PICKER_TYPE_STRINGS);
                    p.setStrings("1","2","3","4","5","6"); //TODO : A changer
                    p.setUIID("TableCell");
                    p.setSelectedString(String.valueOf(products.get(row).getQuantToBuy()));
                    p.addActionListener((e) -> {
                        getModel().setValueAt(row, column, products.get(row).getQuantToBuy());
                        System.out.println(p.getSelectedStringIndex());
                        System.out.println(products);
                        System.out.println(getModel().getValueAt(row,column));
                        products.get(row).setQuantToBuy(Integer.parseInt(p.getSelectedString()));
                        CartService cartService = new CartService();
                        cartService.updateCartItemQuantity(p.getSelectedString(),products.get(row).getId());
                        products.forEach(product -> System.out.println(product.getName() + " " + product.getQuantToBuy() + " \n"));
                        p.setSelectedStringIndex(p.getSelectedStringIndex());
                    });
                    cell = p;
                } else {
                    cell = super.createCell(value, row, column, editable);
                }
                return cell;
            }

            @Override
            protected TableLayout.Constraint createCellConstraint(Object value, int row, int column) {
                TableLayout.Constraint con =  super.createCellConstraint(value, row, column);
                if(row == 1 && column == 1) {
                    con.setHorizontalSpan(2);
                }
                con.setWidthPercentage(33);
                return con;
            }
        };
        Label total = new Label("Total Price : "+
                products.stream().mapToInt(value -> (int) Float.parseFloat(value.getPrice())).sum()
                );

        Container container = new Container(new BoxLayout(BoxLayout.Y_AXIS));
        Button btnPay = new Button("Pay");
        Button btnClear = new Button("Clear");
        container.add(btnPay);
        container.add(btnClear);
        btnPay.addActionListener(evt -> {
            if(products.size()>0)
            new PayForm().show();
        });
        btnClear.addActionListener(evt -> {
            CartService.getInstance().clearCart();
            new CartForm().show();
        });
        add(TOP,table);
        add(CENTER,container);
        add(BOTTOM,total);
    }
    
//-- DON'T EDIT BELOW THIS LINE!!!


// <editor-fold defaultstate="collapsed" desc="Generated Code">                          
    private void initGuiBuilderComponents(com.codename1.ui.util.Resources resourceObjectInstance) {
        setLayout(new com.codename1.ui.layouts.BorderLayout());
        setInlineStylesTheme(resourceObjectInstance);
                setInlineStylesTheme(resourceObjectInstance);
        setTitle("CartForm");
        setName("CartForm");
    }// </editor-fold>

//-- DON'T EDIT ABOVE THIS LINE!!!
}
