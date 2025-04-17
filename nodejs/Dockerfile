FROM node:22
WORKDIR /app

COPY ./package.json .
COPY ./package-lock.json .

RUN npm install -g pm2 npm && npm install

COPY ./src ./src
CMD ["pm2-runtime", "src/server.js"]