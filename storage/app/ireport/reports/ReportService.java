/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package view.reports;

import java.sql.Connection;
import java.util.Map;
import javax.swing.JOptionPane;
import net.sf.jasperreports.engine.JRException;
import net.sf.jasperreports.engine.JasperFillManager;
import net.sf.jasperreports.engine.JasperPrint;
import net.sf.jasperreports.engine.JasperReport;
import net.sf.jasperreports.engine.util.JRLoader;
import net.sf.jasperreports.swing.JRViewer;

/**
 *
 * @author user
 */
public class ReportService {

    String filename;
    Map<String, Object> params; 
    Connection conn = null;
    JRViewer viewer = null;
            
    public ReportService(String filename, Map<String, Object> params, Connection conn) {
        this.filename = filename;
        this.params = params;
        this.conn = conn;
    }
    
    public JRViewer getViewer(){
        try {
            JasperReport report = (JasperReport) JRLoader.loadObject(getClass().getResource(filename+".jasper"));
            JasperPrint print = JasperFillManager.fillReport(report, params, conn);
            // TODO: cuando hay una exepcion se sierra la conexion provar en este punto lanzado una manualmente
          
            viewer = new JRViewer(print);
            viewer.setVisible(true);
        } catch (Exception e) {
            JOptionPane.showMessageDialog(null, e.getMessage(), "Error", JOptionPane.ERROR_MESSAGE);
        }
        return viewer;
    }
    
    public static JRViewer get(String filename, Map<String, Object> params, Connection conn){
        ReportService r = new ReportService(filename, params, conn);
        return r.getViewer();
    }
    
}
