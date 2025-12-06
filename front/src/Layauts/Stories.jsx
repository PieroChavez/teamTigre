import React, { useState, useEffect } from "react";

const Stories = () => {
  const [activeStory, setActiveStory] = useState(null);

  // Ejemplo de historias
  const stories = [
    { id: 1, name: "Carlos", story: "https://picsum.photos/500/800?random=1" },
    { id: 2, name: "María", story: "https://picsum.photos/500/800?random=2" },
    { id: 3, name: "Lucía", story: "https://picsum.photos/500/800?random=3" },
    // Ejemplo video
    { id: 4, name: "Pedro", story: "https://www.w3schools.com/html/mov_bbb.mp4" },
  ];

  // Avatares de ejemplo
  const avatarstorie = [
    { id: 1, avatar: "https://i.pravatar.cc/150?img=1" },
    { id: 2, avatar: "https://i.pravatar.cc/150?img=2" },
    { id: 3, avatar: "https://i.pravatar.cc/150?img=3" },
    { id: 4, avatar: "https://i.pravatar.cc/150?img=4" },
  ];

  // Quita el story activo después de 3s
  useEffect(() => {
    if (activeStory !== null) {
      const timer = setTimeout(() => {
        setActiveStory(null);
      }, 3000);
      return () => clearTimeout(timer);
    }
  }, [activeStory]);

  // Combinar historia + avatar
  const combinedData = stories.map((story) => {
    const avatar = avatarstorie.find((a) => a.id === story.id);
    const extension = story.story.split(".").pop().toLowerCase();
    const type = extension === "mp4" ? "video" : "image";

    return {
      ...story,
      avatar: avatar?.avatar || "",
      type,
    };
  });

  return (
    <div style={{ padding: "1rem" }}>
      {activeStory === null ? (
        <div
          style={{
            display: "flex",
            gap: "1rem",
            overflowX: "auto",
            justifyContent: "center",
            alignItems: "center",
            width: "100%",
          }}
        >
          {combinedData.map((user) => (
            <div
              key={user.id}
              style={{ textAlign: "center", cursor: "pointer" }}
              onClick={() => setActiveStory(user)}
            >
              <img
                src={user.avatar}
                alt={user.name}
                style={{
                  width: "60px",
                  height: "60px",
                  borderRadius: "50%",
                  border: "2px solid #f43f5e",
                  objectFit: "cover",
                }}
              />
              <p style={{ fontSize: "12px", marginTop: "0.5rem" }}>
                {user.name}
              </p>
            </div>
          ))}
        </div>
      ) : (
        <div
          style={{
            position: "relative",
            height: "300px",
            backgroundColor: "#000",
            borderRadius: "1rem",
            overflow: "hidden",
          }}
        >
          {activeStory.type === "image" ? (
            <img
              src={activeStory.story}
              alt="story"
              style={{ width: "100%", height: "100%", objectFit: "cover" }}
            />
          ) : (
            <video
              src={activeStory.story}
              autoPlay
              muted
              style={{ width: "100%", height: "100%", objectFit: "cover" }}
            />
          )}

          <p
            style={{
              position: "absolute",
              top: "1rem",
              left: "1rem",
              color: "#fff",
              fontWeight: "bold",
            }}
          >
            {activeStory.name}
          </p>
        </div>
      )}
    </div>
  );
};

export default Stories;
