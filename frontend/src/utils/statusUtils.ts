export const getStatusClass = (status: string): string => {
    const statusMap: Record<string, string> = {
      solicitado: "badge-primary",
      aprovado: "badge-success",   
      cancelado: "badge-danger",   
    };
  
    return statusMap[status.toLowerCase()] || "badge-secondary"; 
  };
  